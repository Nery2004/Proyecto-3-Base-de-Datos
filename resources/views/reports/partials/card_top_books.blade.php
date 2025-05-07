<div class="col">
    <div class="card shadow-sm h-100">
        <div class="card-header fw-bold">Top Libros Prestados</div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" class="row g-3">
                <input type="hidden" name="report_type" value="top_books">

                <div class="col-12">
                    <label for="tb_start_date" class="form-label">Fecha inicio</label>
                    <input id="tb_start_date" name="start_date" type="date" class="form-control" value="{{ $filters['start_date'] ?? '' }}">
                </div>
                <div class="col-12">
                    <label for="tb_end_date" class="form-label">Fecha fin</label>
                    <input id="tb_end_date" name="end_date" type="date" class="form-control" value="{{ $filters['end_date'] ?? '' }}">
                </div>

                <div class="col-12">
                    <label for="tb_editorial_id" class="form-label">Editorial</label>
                    <select id="tb_editorial_id" name="editorial_id" class="form-select">
                        <option value="">Todas</option>
                        @foreach($editoriales as $id => $nombre)
                            <option value="{{ $id }}" {{ ($filters['editorial_id'] ?? '') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="tb_category_id" class="form-label">Categoría</label>
                    <select id="tb_category_id" name="category_id" class="form-select">
                        <option value="">Todas</option>
                        @foreach($categorias as $id => $cat)
                            <option value="{{ $id }}" {{ ($filters['category_id'] ?? '') == $id ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label for="tb_author_id" class="form-label">Autor</label>
                    <select id="tb_author_id" name="author_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($autores as $id => $a)
                            <option value="{{ $id }}" {{ ($filters['author_id'] ?? '') == $id ? 'selected' : '' }}>{{ $a }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6">
                    <label for="tb_min_count" class="form-label">Mínimo</label>
                    <input id="tb_min_count" name="min_count" type="number" min="0" class="form-control" value="{{ $filters['min_count'] ?? 0 }}">
                </div>
                <div class="col-6">
                    <label for="tb_limit" class="form-label">Límite</label>
                    <input id="tb_limit" name="limit" type="number" min="1" class="form-control" value="{{ $filters['limit'] ?? 10 }}">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </form>
        </div>
    </div>
</div>