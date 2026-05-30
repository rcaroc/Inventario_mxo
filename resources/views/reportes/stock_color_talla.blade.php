@extends('layouts.app')

@section('css')
<style>
    /* Ocultar botones originales de DataTables (los plomos) */
    .dt-buttons {
        display: none !important;
    }
    
    .btn-export-excel { background-color: #48c78e !important; color: white !important; border: none !important; }
    .btn-export-pdf { background-color: #5dade2 !important; color: white !important; border: none !important; }
    .form-label { font-size: 0.85rem; margin-bottom: 4px; }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="mb-2">
        <h1 class="fw-bold text-dark mb-0">Reportes</h1>
        <p class="text-muted">Stock por color y talla</p>
    </div>

    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted">Modelo</label>
                    <select id="filtro-modelo" class="form-select">
                        <option value="">Todos los modelos</option>
                        @foreach($modelos as $m)
                            <option value="{{ $m->modelo_nombre }}">{{ $m->modelo_nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted">Color (contiene)</label>
                    <select id="filtro-color" class="form-select">
                        <option value="">Todos los colores</option>
                        @foreach($colores as $color)
                            <option value="{{ $color }}">{{ ucfirst($color) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-muted">Talla (exacta)</label>
                    <select id="filtro-talla" class="form-select">
                        <option value="">Todas las tallas</option>
                        @foreach($tallas as $talla)
                            <option value="{{ $talla }}">{{ strtoupper($talla) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex align-items-center">
                <button id="btn-aplicar" class="btn btn-primary px-4 me-2 shadow-sm">Aplicar</button>
                <button id="btn-limpiar" class="btn btn-light px-4 border me-auto">Limpiar</button>
                
                <button id="btn-excel-custom" class="btn btn-export-excel px-3 me-2 shadow-sm text-white">
                    <i class="fas fa-file-excel me-1"></i> Exportar Excel
                </button>
                <button id="btn-pdf-custom" class="btn btn-export-pdf px-3 shadow-sm text-white">
                    <i class="fas fa-file-pdf me-1"></i> Exportar PDF
                </button>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tabla-color-talla" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Modelo</th>
                            <th>Color</th>
                            <th class="text-center">Talla</th>
                            <th class="text-center">Stock total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reporte as $prod)
                        <tr>
                            <td class="fw-bold">{{ $prod->modelo->modelo_nombre ?? '---' }}</td>
                            <td class="text-muted">{{ $prod->producto_color }}</td>
                            <td class="text-center">{{ $prod->producto_talla }}</td>
                            <td class="text-center fw-bold">
                                <span class="{{ ($prod->stock->cantidad ?? 0) <= 0 ? 'text-danger' : '' }}">
                                    {{ $prod->stock->cantidad ?? 0 }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light border-top">
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end py-3">Total general</td>
                            <td class="text-center py-3 fs-5 text-primary">0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Registrar fuentes para PDF antes de iniciar
    if (window.pdfMake) {
        pdfMake.vfs = pdfMake.vfs;
    }

    var table = $('#tabla-color-talla').DataTable({
        "order": [[ 0, "asc" ]],
        "language": { "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" },
        "dom": 'Brtip', 
        "buttons": [
            { 
                extend: 'excelHtml5', 
                footer: true,
                title: 'Reporte Stock por Color y Talla'
            },
            { 
                extend: 'pdfHtml5', 
                footer: true,
                title: 'Reporte Stock por Color y Talla',
                customize: function(doc) {
                    // Limpia el texto repetido del footer en el PDF
                    var footerRow = doc.content[1].table.footer[0];
                    if (footerRow) {
                        footerRow[1].text = ''; // Columna Color
                        footerRow[2].text = ''; // Columna Talla
                    }
                }
            }
        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api();
            var intVal = function (i) {
                if (typeof i === 'string') {
                    let cleaned = i.replace(/<[^>]*>?/gm, '').trim();
                    return cleaned === '' ? 0 : parseFloat(cleaned);
                }
                return typeof i === 'number' ? i : 0;
            };

            total = api.column(3, { filter: 'applied' }).data().reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            $(api.column(3).footer()).html(total);
        }
    });

    // Acción de botones personalizados
    $('#btn-excel-custom').on('click', function() {
        table.button(0).trigger();
    });

    $('#btn-pdf-custom').on('click', function() {
        table.button(1).trigger();
    });

    // Filtros
    $('#btn-aplicar').on('click', function() {
        table.column(0).search($('#filtro-modelo').val());
        let color = $('#filtro-color').val();
        table.column(1).search(color ? '^' + color + '$' : '', true, false);
        let talla = $('#filtro-talla').val();
        table.column(2).search(talla ? '^' + talla + '$' : '', true, false);
        table.draw();
    });

    $('#btn-limpiar').on('click', function() {
        $('#filtro-modelo, #filtro-color, #filtro-talla').val('');
        table.columns().search('').draw();
    });
});
</script>
@endsection