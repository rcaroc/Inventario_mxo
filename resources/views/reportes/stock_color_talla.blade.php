@extends('layouts.app')

@section('css')
<style>
    .btn-export-excel { background-color: #48c78e !important; color: white !important; border: none !important; padding: 8px 20px; }
    .btn-export-pdf { background-color: #5c6bc0 !important; color: white !important; border: none !important; padding: 8px 20px; }
    .btn-export-excel:hover, .btn-export-pdf:hover { opacity: 0.9; color: white !important; }
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
            
            <button id="btn-export-excel-manual" class="btn btn-success me-2 shadow-sm" style="background-color: #48c78e; border:none;">
                <i class="fas fa-file-excel me-1"></i> Exportar Excel
            </button>
            <button id="btn-export-pdf-manual" class="btn btn-primary shadow-sm" style="background-color: #5dade2; border:none;">
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
                            <td class="fw-bold text-dark">{{ $prod->modelo->modelo_nombre ?? '---' }}</td>
                            <td class="text-muted">{{ $prod->producto_color }}</td>
                            <td class="text-center">{{ $prod->producto_talla }}</td>
                            <td class="text-center fw-bold">
                                <span class="{{ ($prod->stock->cantidad ?? 0) <= 0 ? 'text-danger' : 'text-dark' }}">
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
    // ESTA LÍNEA ES EL TRUCO: Registra las fuentes manualmente antes de la tabla
    if (typeof pdfMake !== 'undefined') {
        pdfMake.vfs = pdfMake.vfs; 
    }

    var table = $('#tabla-color-talla').DataTable({
        "order": [[ 0, "asc" ]],
        "language": { "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" },
        "dom": 'Brtip', // Mantenemos la B para que existan los botones
        "buttons": [
            { 
                extend: 'excelHtml5', 
                title: 'Reporte Stock',
                footer: true 
            },
            { 
                extend: 'pdfHtml5', 
                title: 'Reporte Stock',
                footer: true,
                exportOptions: { columns: ':visible' },
                customize: function(doc) {
                    // Limpieza de footer repetido
                    var footerRow = doc.content[1].table.footer[0];
                    if (footerRow) {
                        footerRow[1].text = ''; 
                        footerRow[2].text = ''; 
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

    // Ocultamos los botones que DataTables crea automáticamente (los feos)
    table.buttons().container().addClass('d-none');

    // BOTONES PERSONALIZADOS (Los que tú tienes en el HTML)
    // Buscamos el botón de Excel (índice 0) y PDF (índice 1)
    $('#btn-export-excel-manual').on('click', function() {
        table.button(0).trigger();
    });

    $('#btn-export-pdf-manual').on('click', function() {
        console.log("Generando PDF..."); // Si ves esto en F12, el botón está vivo
        table.button(1).trigger();
    });

    // Filtros Aplicar / Limpiar
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