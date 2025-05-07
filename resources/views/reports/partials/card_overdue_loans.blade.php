<div class="col">
    <div class="card shadow-sm h-100">
        <div class="card-header fw-bold">Préstamos Vencidos</div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3">
                <input type="hidden" name="report_type" value="overdue_loans">

                <div class="col-12">
                    <label for="ol_start_date" class="form-label">Fecha inicio</label>
                    <input id="ol_start_date" name="start_date" type="date" class="form-control" value="{{ $filters['start_date'] ?? '' }}">
                </div>
                <div class="col-12">
                    <label for="ol_end_date" class="form-label">Fecha fin</label>
                    <input id="ol_end_date" name="end_date" type="date" class="form-control" value="{{ $filters['end_date'] ?? '' }}">
                </div>

                <div class="col-12">
                    <label for="ol_client_id" class="form-label">Cliente</label>
                    <select id="ol_client_id" name="client_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($clients as $id => $c)
                            <option value="{{ $id }}" {{ ($filters['client_id'] ?? '') == $id ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="ol_bibliotecario_id" class="form-label">Bibliotecario</label>
                    <select id="ol_bibliotecario_id" name="bibliotecario_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($bibliotecarios as $id => $b)
                            <option value="{{ $id }}" {{ ($filters['bibliotecario_id'] ?? '') == $id ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6">
                    <label for="ol_min_days" class="form-label">Mín días atraso</label>
                    <input id="ol_min_days" name="min_days_overdue" type="number" min="0" class="form-control" value="{{ $filters['min_days_overdue'] ?? '' }}">
                </div>
                <div class="col-6">
                    <label for="ol_max_days" class="form-label">Máx días atraso</label>
                    <input id="ol_max_days" name="max_days_overdue" type="number" min="0" class="form-control" value="{{ $filters['max_days_overdue'] ?? '' }}">
                </div>

                <div class="col-6">
                    <label for="ol_limit" class="form-label">Límite</label>
                    <input id="ol_limit" name="limit" type="number" min="1" class="form-control" value="{{ $filters['limit'] ?? 10 }}">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-outline-primary">Filtrar</button>
                </div>
            </form>
        </div>
    </div>
</div>