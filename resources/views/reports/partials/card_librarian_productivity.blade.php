<div class="col">
    <div class="card shadow-sm h-100">
        <div class="card-header fw-bold">Productividad de Bibliotecarios</div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3">
                <input type="hidden" name="report_type" value="librarian_productivity">

                {{-- Rango de fechas --}}
                <div class="col-12">
                    <label for="lp_start_date" class="form-label">Fecha inicio</label>
                    <input id="lp_start_date"
                           name="start_date"
                           type="date"
                           class="form-control"
                           value="{{ $filters['start_date'] ?? '' }}">
                </div>
                <div class="col-12">
                    <label for="lp_end_date" class="form-label">Fecha fin</label>
                    <input id="lp_end_date"
                           name="end_date"
                           type="date"
                           class="form-control"
                           value="{{ $filters['end_date'] ?? '' }}">
                </div>

                {{-- Bibliotecario específico --}}
                <div class="col-12">
                    <label for="lp_bibliotecario_id" class="form-label">Bibliotecario</label>
                    <select id="lp_bibliotecario_id"
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

                {{-- Filtros de desempeño --}}
                <div class="col-6">
                    <label for="lp_min_loans" class="form-label">Mín préstamos</label>
                    <input id="lp_min_loans"
                           name="min_loans"
                           type="number"
                           min="0"
                           class="form-control"
                           value="{{ $filters['min_loans'] ?? '' }}">
                </div>
                <div class="col-6">
                    <label for="lp_max_loans" class="form-label">Máx préstamos</label>
                    <input id="lp_max_loans"
                           name="max_loans"
                           type="number"
                           min="0"
                           class="form-control"
                           value="{{ $filters['max_loans'] ?? '' }}">
                </div>
                <div class="col-6">
                    <label for="lp_min_clients" class="form-label">Mín clientes distintos</label>
                    <input id="lp_min_clients"
                           name="min_clients"
                           type="number"
                           min="0"
                           class="form-control"
                           value="{{ $filters['min_clients'] ?? '' }}">
                </div>
                <div class="col-6">
                    <label for="lp_limit" class="form-label">Límite</label>
                    <input id="lp_limit"
                           name="limit"
                           type="number"
                           min="1"
                           class="form-control"
                           value="{{ $filters['limit'] ?? 10 }}">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-outline-primary">Filtrar</button>
                </div>
            </form>
        </div>
    </div>
</div>