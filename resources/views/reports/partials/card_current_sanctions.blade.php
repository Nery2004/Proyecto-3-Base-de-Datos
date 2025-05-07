<div class="col">
    <div class="card shadow-sm h-100">
        <div class="card-header fw-bold">Sanciones Vigentes</div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3">
                <input type="hidden" name="report_type" value="current_sanctions">

                <div class="col-12">
                    <label for="cs_start_date" class="form-label">Desde</label>
                    <input id="cs_start_date" name="start_date" type="date" class="form-control" value="{{ $filters['start_date'] ?? '' }}">
                </div>
                <div class="col-12">
                    <label for="cs_end_date" class="form-label">Hasta</label>
                    <input id="cs_end_date" name="end_date" type="date" class="form-control" value="{{ $filters['end_date'] ?? '' }}">
                </div>

                <div class="col-12">
                    <label for="cs_client_id" class="form-label">Cliente</label>
                    <select id="cs_client_id" name="client_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($clients as $id => $c)
                            <option value="{{ $id }}" {{ ($filters['client_id'] ?? '') == $id ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label for="cs_reason" class="form-label">Motivo (palabra clave)</label>
                    <input id="cs_reason" name="sanction_reason" type="text" class="form-control" value="{{ $filters['sanction_reason'] ?? '' }}" placeholder="multa, daño, atraso…">
                </div>

                <div class="col-6">
                    <label for="cs_limit" class="form-label">Límite</label>
                    <input id="cs_limit" name="limit" type="number" min="1" class="form-control" value="{{ $filters['limit'] ?? 10 }}">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>
        </div>
    </div>
</div>