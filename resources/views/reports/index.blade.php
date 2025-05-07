@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Reportes de Biblioteca</h1>

    {{-- REPORTES --}}
    <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
        {{-- 1) Top Libros Prestados --}}
        @include('reports.partials.card_top_books')

        {{-- 2) Préstamos Vencidos --}}
        @include('reports.partials.card_overdue_loans')
        
        {{-- 3) Clientes con más Préstamos Activos --}}
        @include('reports.partials.card_active_clients')

        {{-- 4) Sanciones Vigentes --}}
        @include('reports.partials.card_current_sanctions')

        {{-- 5) Productividad de Bibliotecarios --}}
        @include('reports.partials.card_librarian_productivity')
    </div>

    {{-- GRÁFICO --}}
    @if(!empty($chart))
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Gráfico</h5>
                <div class="chart-container" style="position: relative; height:300px">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        {!! $chart->script() !!}
    @endif

    {{-- TABLA DE RESULTADOS --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Resultados</h5>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        @switch($type)
                            @case('top_books')
                                <tr>
                                    <th>Libro</th>
                                    <th>Veces Prestado</th>
                                </tr>
                                @break
                            @case('overdue_loans')
                                <tr>
                                    <th>ID Préstamo</th>
                                    <th>Cliente</th>
                                    <th>Fecha Devolución</th>
                                    <th>Días Atraso</th>
                                </tr>
                                @break
                            @case('active_clients')
                                <tr>
                                    <th>Cliente</th>
                                    <th>Préstamos Activos</th>
                                </tr>
                                @break
                            @case('current_sanctions')
                                <tr>
                                    <th>Cliente</th>
                                    <th>Motivo</th>
                                    <th>Desde</th>
                                    <th>Hasta</th>
                                </tr>
                                @break
                            @case('librarian_productivity')
                            <tr>
                                <th>Bibliotecario</th>
                                <th>Préstamos</th>
                                <th>Clientes Distintos</th>
                                <th>Prom. días</th>
                            </tr>
                            @break                            
                        @endswitch
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                            <tr>
                                @switch($type)
                                    @case('top_books')
                                        <td>{{ $row->label }}</td>
                                        <td>{{ $row->value }}</td>
                                        @break
                                    @case('overdue_loans')
                                        <td>{{ $row->loan_id }}</td>
                                        <td>{{ $row->cliente }}</td>
                                        <td>{{ $row->fecha_devolucion }}</td>
                                        <td>{{ $row->days_overdue }}</td>
                                        @break
                                    @case('active_clients')
                                        <td>{{ $row->label }}</td>
                                        <td>{{ $row->value }}</td>
                                        @break
                                    @case('current_sanctions')
                                        <td>{{ $row->cliente }}</td>
                                        <td>{{ $row->motivo }}</td>
                                        <td>{{ $row->fecha_inicio }}</td>
                                        <td>{{ $row->fecha_final ?? '—' }}</td>
                                        @break
                                    @case('librarian_productivity')
                                        <td>{{ $row->label }}</td>
                                        <td>{{ $row->value }}</td>
                                        <td>{{ $row->unique_clients }}</td>
                                        <td>{{ $row->avg_days }}</td>
                                        @break                                    
                                @endswitch
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">No hay resultados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- EXPORTAR --}}
            <div class="d-flex justify-content-end">
                <a href="{{ route('reports.exportPdf', request()->query()) }}" class="btn btn-danger me-2">
                    <i class="bi bi-file-earmark-pdf"></i> PDF
                </a>
                <a href="{{ route('reports.exportExcel', request()->query()) }}" class="btn btn-success">
                    <i class="bi bi-file-earmark-excel"></i> Excel
                </a>
            </div>
        </div>
    </div>
</div>
@endsection