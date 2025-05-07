<div class="col">
    <div class="card shadow-sm h-100">
        <div class="card-header fw-bold">Clientes Activos</div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3">
                <input type="hidden" name="report_type" value="active_clients">

                <div class="col-12">
                    <label for="ac_start_date" class="form-label">Fecha inicio</label>
                    <input id="ac_start_date"
                           name="start_date"
                           type="date"
                           class="form-control"
                           value="{{ $filters['start_date'] ?? '' }}">
                </div>
                <div class="col-12">
                    <label for="ac_end_date" class="form-label">Fecha fin</label>
                    <input id="ac_end_date"
                           name="end_date"
                           type="date"
                           class="form-control"
                           value="{{ $filters['end_date'] ?? '' }}">
                </div>

                <div class="col-12">
                    <label for="ac_bibliotecario_id" class="form-label">Bibliotecario</label>
                    <select id="ac_bibliotecario_id"
                            name="bibliotecario_id"
                            class="form-select">
                        <option value="">Todos</option>
                        @foreach($bibliotecarios as $id => $b)
                            <option value="{{ $id }}"
                                {{ ($filters['bibliotecario_id'] ?? '') == $id ? 'selected' : '' }}>
                                {{ $b }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6">
                    <label for="ac_min_count" class="form-label">Mín préstamos</label>
                    <input id="ac_min_count"
                           name="min_count"
                           type="number"
                           min="0"
                           class="form-control"
                           value="{{ $filters['min_count'] ?? 0 }}">
                </div>
                <div class="col-6">
                    <label for="ac_limit" class="form-label">Límite</label>
                    <input id="ac_limit"
                           name="limit"
                           type="number"
                           min="1"
                           class="form-control"
                           value="{{ $filters['limit'] ?? 10 }}">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>
        </div>
    </div>
</div>