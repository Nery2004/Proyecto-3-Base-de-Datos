@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">📊 Reportes de Biblioteca</h1>

    {{-- FILTROS --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3">
                {{-- Tipo de reporte --}}
                <div class="col-md-3">
                    <label for="report_type" class="form-label">Tipo de reporte</label>
                    <select id="report_type" name="report_type" class="form-select">
                        <option value="top_books"      {{ $type=='top_books'      ?'selected':'' }}>Top Libros Prestados</option>
                        <option value="overdue_loans"  {{ $type=='overdue_loans'  ?'selected':'' }}>Préstamos Vencidos</option>
                        <option value="active_clients" {{ $type=='active_clients' ?'selected':'' }}>Clientes Activos</option>
                        <option value="current_sanctions" {{ $type=='current_sanctions'?'selected':'' }}>Sanciones Vigentes</option>
                    </select>
                </div>

                {{-- Fechas desde / hasta --}}
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Fecha inicio</label>
                    <input id="start_date" name="start_date" type="date" class="form-control" value="{{ $filters['start_date'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">Fecha fin</label>
                    <input id="end_date" name="end_date" type="date" class="form-control" value="{{ $filters['end_date'] ?? '' }}">
                </div>

                {{-- Mínimos / Límite --}}
                <div class="col-md-2">
                    <label for="min_count" class="form-label">Mínimo</label>
                    <input id="min_count" name="min_count" type="number" class="form-control" min="0" value="{{ $filters['min_count'] ?? 0 }}">
                </div>
                <div class="col-md-2">
                    <label for="limit" class="form-label">Límite</label>
                    <input id="limit" name="limit" type="number" class="form-control" min="1" value="{{ $filters['limit'] ?? 10 }}">
                </div>

                {{-- Filtros extra (editorial, categoría, autor, cliente, biblio) --}}
                <div class="col-md-3">
                    <label for="editorial_id" class="form-label">Editorial</label>
                    <select id="editorial_id" name="editorial_id" class="form-select">
                        <option value="">Todas</option>
                        @foreach($editoriales as $id => $nombre)
                            <option value="{{ $id }}" {{ ($filters['editorial_id'] ?? '') == $id ? 'selected':'' }}>
                                {{ $nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="category_id" class="form-label">Categoría</label>
                    <select id="category_id" name="category_id" class="form-select">
                        <option value="">Todas</option>
                        @foreach($categorias as $id => $cat)
                            <option value="{{ $id }}" {{ ($filters['category_id'] ?? '') == $id ? 'selected':'' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="author_id" class="form-label">Autor</label>
                    <select id="author_id" name="author_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($autores as $id => $a)
                            <option value="{{ $id }}" {{ ($filters['author_id'] ?? '') == $id ? 'selected':'' }}>
                                {{ $a }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="client_id" class="form-label">Cliente</label>
                    <select id="client_id" name="client_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($clients as $id => $c)
                            <option value="{{ $id }}" {{ ($filters['client_id'] ?? '') == $id ? 'selected':'' }}>
                                {{ $c }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="bibliotecario_id" class="form-label">Bibliotecario</label>
                    <select id="bibliotecario_id" name="bibliotecario_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($bibliotecarios as $id => $b)
                            <option value="{{ $id }}" {{ ($filters['bibliotecario_id'] ?? '') == $id ? 'selected':'' }}>
                                {{ $b }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtros para vencidos y sanciones --}}
                <div class="col-md-3">
                    <label for="min_days_overdue" class="form-label">Mín días atraso</label>
                    <input id="min_days_overdue" name="min_days_overdue" type="number" class="form-control" min="0" value="{{ $filters['min_days_overdue'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="max_days_overdue" class="form-label">Máx días atraso</label>
                    <input id="max_days_overdue" name="max_days_overdue" type="number" class="form-control" min="0" value="{{ $filters['max_days_overdue'] ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label for="sanction_reason" class="form-label">Motivo sanción</label>
                    <input id="sanction_reason" name="sanction_reason" type="text" class="form-control" placeholder="palabra clave" value="{{ $filters['sanction_reason'] ?? '' }}">
                </div>

                {{-- Botón Filtrar --}}
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    {{-- CHART --}}
    @if(!empty($chart))
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">{{ __('Gráfico') }}</h5>
                <div class="chart-container" style="position: relative; height:300px">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        {!! $chart->script() !!}
    @endif

    {{-- TABLA --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">{{ __('Resultados') }}</h5>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        @switch($type)
                            @case('top_books')
                                <tr><th>Libro</th><th>Veces Prestado</th></tr>
                                @break
                            @case('overdue_loans')
                                <tr><th>ID Préstamo</th><th>Cliente</th><th>Fecha Devolución</th><th>Días Atraso</th></tr>
                                @break
                            @case('active_clients')
                                <tr><th>Cliente</th><th>Préstamos Activos</th></tr>
                                @break
                            @case('current_sanctions')
                                <tr><th>Cliente</th><th>Motivo</th><th>Desde</th><th>Hasta</th></tr>
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
                                @endswitch
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">No hay resultados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- EXPORT --}}
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