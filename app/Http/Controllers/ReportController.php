<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;
use App\Models\Editorial;
use App\Models\Categoria;
use App\Models\Autor;
use App\Models\Cliente;
use App\Models\Bibliotecario;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Recogemos filtros
        $type    = $request->input('report_type', 'top_books');
        $filters = $request->only([
            'start_date','end_date','min_count','limit',
            'editorial_id','category_id','author_id',
            'client_id','bibliotecario_id',
            'min_days_overdue','max_days_overdue','sanction_reason'
        ]);

        // Obtenemos datos según tipo
        $data = $this->getData($filters);

        // Sólo para los reportes numéricos, armamos gráfico
        $numericReports = ['top_books', 'active_clients'];
        $chart = in_array($type, $numericReports)
            ? $this->buildChart($data, $type)
            : null;

        $editoriales    = Editorial::pluck('nombre','id');
        $categorias     = Categoria::pluck('categoria','id');
        $autores        = Autor::pluck('usuario_id','id');       // o nombres
        $clients        = Cliente::with('usuario')->get()->pluck('usuario.nombre','id');
        $bibliotecarios = Bibliotecario::with('usuario')->get()->pluck('usuario.nombre','id');
        
        return view('reports.index', compact(
            'data','chart','filters','type',
            'editoriales','categorias','autores','clients','bibliotecarios'
        ));
    }

    public function exportPdf(Request $request)
    {
        $filters = $request->all();
        $data    = $this->getData($filters);
        $chart   = in_array($filters['report_type'], ['top_books','active_clients'])
            ? $this->buildChart($data, $filters['report_type'])
            : null;

        $pdf = Pdf::loadView('reports.pdf', compact('data','chart','filters'));
        return $pdf->download("reporte_{$filters['report_type']}.pdf");
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new ReportsExport($request->all()),
            "reporte_{$request->input('report_type')}.xlsx"
        );
    }

    /**
     * Devuelve un Collection con los datos del reporte
     */
    protected function getData(array $f)
    {
        $type  = $f['report_type'] ?? 'top_books';
        $start = $f['start_date']   ?? null;
        $end   = $f['end_date']     ?? null;
        $min   = $f['min_count']    ?? 0;
        $limit = $f['limit']        ?? 10;

        switch ($type) {
            // 1) Top Libros Prestados
            case 'top_books':
                $q = DB::table('prestamo')
                    ->join('libros','prestamo.libro_id','=','libros.id')
                    ->join('editoriales','libros.editorial_id','=','editoriales.id')
                    ->when($start && $end, fn($q) => $q->whereBetween('prestamo.prestado_en', [$start, $end]))
                    ->when($f['min_count'] ?? null, fn($q,$min) => $q->havingRaw('count(*) >= ?', [$min]))
                    ->when($f['editorial_id'] ?? null, fn($q,$ed) => $q->where('editoriales.id', $ed))
                    ->when($f['category_id'] ?? null, fn($q,$cat) => 
                        $q->join('libro_categorias','libros.id','=','libro_categorias.libro_id')
                          ->where('libro_categorias.categoria_id',$cat)
                    )
                    ->when($f['author_id'] ?? null, fn($q,$a) =>
                        $q->join('autor_libro','libros.id','=','autor_libro.libro_id')
                          ->where('autor_libro.autor_id',$a)
                    )
                    ->select('libros.titulo AS label', DB::raw('count(*) AS value'))
                    ->groupBy('libros.titulo')
                    ->orderByDesc('value')
                    ->limit($limit);
                return $q->get();

            // 2) Préstamos Vencidos
            case 'overdue_loans':
                $q = DB::table('prestamo')
                    ->join('clientes','prestamo.cliente_id','=','clientes.id')
                    ->join('usuarios','clientes.usuario_id','=','usuarios.id')
                    ->whereNull('prestamo.devuelto_en')
                    ->where('prestamo.fecha_devolucion','<', DB::raw('CURRENT_DATE'))
                    ->when($start && $end, fn($q) => $q->whereBetween('prestado_en', [$start, $end]))
                    ->when($f['min_days_overdue'] ?? null, fn($q,$min) =>
                        $q->whereRaw("DATE_PART('day', CURRENT_DATE - fecha_devolucion) >= ?", [$min])
                    )
                    ->when($f['max_days_overdue'] ?? null, fn($q,$max) =>
                        $q->whereRaw("DATE_PART('day', CURRENT_DATE - fecha_devolucion) <= ?", [$max])
                    )
                    ->when($f['client_id'] ?? null, fn($q,$c) => $q->where('clientes.id',$c))
                    ->when($f['bibliotecario_id'] ?? null, fn($q,$b) => $q->where('prestamo.bibliotecario_id',$b))
                    ->select(
                        'prestamo.id AS loan_id',
                        DB::raw("usuarios.nombre || ' ' || usuarios.apellido AS cliente"),
                        'prestamo.fecha_devolucion',
                        DB::raw("DATE_PART('day', CURRENT_DATE - fecha_devolucion) AS days_overdue")
                    )
                    ->limit($limit);
                return $q->get();

            // 3) Clientes con más préstamos activos
            case 'active_clients':
                $q = DB::table('prestamo')
                    ->join('clientes','prestamo.cliente_id','=','clientes.id')
                    ->join('usuarios','clientes.usuario_id','=','usuarios.id')
                    ->whereNull('prestamo.devuelto_en')
                    ->when($f['client_id'] ?? null, fn($q,$c) => $q->where('clientes.id',$c))
                    ->select(
                        DB::raw("usuarios.nombre || ' ' || usuarios.apellido AS label"),
                        DB::raw("count(*) AS value")
                    )
                    ->groupBy('usuarios.nombre','usuarios.apellido')
                    ->when($min, fn($q) => $q->havingRaw('count(*) >= ?', [$min]))
                    ->orderByDesc('value')
                    ->limit($limit);
                return $q->get();

            // 4) Sanciones Vigentes
            case 'current_sanctions':
                $q = DB::table('sanciones')
                    ->join('clientes','sanciones.cliente_id','=','clientes.id')
                    ->join('usuarios','clientes.usuario_id','=','usuarios.id')
                    ->where('fecha_inicio','<=', DB::raw('CURRENT_DATE'))
                    ->where(function($q){
                        $q->whereNull('fecha_final')
                          ->orWhere('fecha_final','>=', DB::raw('CURRENT_DATE'));
                    })
                    ->when($start ?? null, fn($q,$d) => $q->where('fecha_inicio','>=',$d))
                    ->when($end ?? null, fn($q,$d) => $q->where('fecha_final','<=',$d))
                    ->when($f['client_id'] ?? null, fn($q,$c) => $q->where('clientes.id',$c))
                    ->when($f['sanction_reason'] ?? null, fn($q,$r) =>
                        $q->where('motivo','ilike', "%{$r}%")
                    )
                    ->select(
                        DB::raw("usuarios.nombre || ' ' || usuarios.apellido AS cliente"),
                        'motivo','fecha_inicio','fecha_final'
                    )
                    ->limit($limit);
                return $q->get();

            default:
                return collect();
        }
    }

    /**
     * Genera un ChartJS de barras para datos con 'label' y 'value'
     */
    protected function buildChart($data, $type)
    {
        $chart = new Chart;
        $chart->labels($data->pluck('label')->toArray());
        $chart->dataset(ucwords(str_replace('_',' ', $type)), 'bar', $data->pluck('value')->toArray());
        return $chart;
    }
}