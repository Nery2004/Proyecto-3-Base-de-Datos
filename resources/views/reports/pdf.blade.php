<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Biblioteca</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 12px; 
            padding: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }
        h1 { 
            color: #336699; 
            margin: 0;
            font-size: 22px;
        }
        h2 {
            color: #333;
            font-size: 16px;
            margin-top: 5px;
        }
        .info {
            margin: 20px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .info p {
            margin: 5px 0;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
            font-size: 11px;
        }
        th { 
            background-color: #f2f2f2; 
            color: #333;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #666;
            position: absolute;
            bottom: 20px;
            width: 100%;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sistema de Biblioteca</h1>
        <h2>{{ ucwords(str_replace('_', ' ', $filters['report_type'] ?? 'desconocido')) }}</h2>
    </div>

    <div class="info">
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        
        @if(!empty($filters['start_date']) || !empty($filters['end_date']))
            <p><strong>Período:</strong> 
                {{ !empty($filters['start_date']) ? \Carbon\Carbon::parse($filters['start_date'])->format('d/m/Y') : 'Sin fecha inicial' }} 
                - 
                {{ !empty($filters['end_date']) ? \Carbon\Carbon::parse($filters['end_date'])->format('d/m/Y') : 'Sin fecha final' }}
            </p>
        @endif
        
        @if(!empty($filters['editorial_id']) || !empty($filters['category_id']) || !empty($filters['author_id']))
            <p><strong>Filtros adicionales aplicados:</strong> 
                {{ !empty($filters['editorial_id']) ? 'Editorial, ' : '' }}
                {{ !empty($filters['category_id']) ? 'Categoría, ' : '' }}
                {{ !empty($filters['author_id']) ? 'Autor, ' : '' }}
                {{ !empty($filters['client_id']) ? 'Cliente, ' : '' }}
                {{ !empty($filters['bibliotecario_id']) ? 'Bibliotecario' : '' }}
            </p>
        @endif
    </div>

    @if($data->isEmpty())
        <div class="no-data">
            <p>No hay datos disponibles con los filtros seleccionados.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    @foreach(array_keys((array)$data->first()) as $col)
                        <th>{{ ucwords(str_replace('_',' ', $col)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($data as $row)
                    <tr>
                        @foreach((array)$row as $cell)
                            <td>{{ $cell }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>© {{ date('Y') }} Sistema de Gestión Bibliotecaria</p>
    </div>
</body>
</html>