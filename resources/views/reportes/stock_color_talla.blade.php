@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-2">
        <h1 class="fw-bold text-dark mb-0">Reportes</h1>
        <p class="text-muted">Stock por color y talla</p>
    </div>

    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px;">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Modelo</label>
                    <select id="filtro-modelo" class="form-select">
                        <option value="">Todos los modelos</option>
                        @foreach($modelos as $m)
                            <option value="{{ $m->modelo_nombre }}">{{ $m->modelo_nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Color (contiene)</label>
                    <input type="text" id="filtro-color" class="form-control" placeholder="Ej: azul, claro...">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Talla (exacta)</label>
                    <input type="text" id="filtro-talla" class="form-control" placeholder="Ej: S, M, L, XL...">
                </div>
            </div>
            <div class="mt-3">
                <button id="btn-aplicar" class="btn btn-primary px-4 shadow-sm">Aplicar</button>
                <button id="btn-limpiar" class="btn btn-outline-secondary px-4 ms-2">Limpiar</button>
            </div>
        </div>
    </div>

    <div id="wrapper-botones" class="mb-3"></div>

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
                            <td>{{ $prod->producto_color }}</td>
                            <td class="text-center">{{ $prod->producto_talla }}</td>
                            <td class="text-center fw-bold">
                                <span class="{{ ($prod->stock->cantidad ?? 0) <= 0 ? 'text-danger' : '' }}">
                                    {{ $prod->stock->cantidad ?? 0 }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Inicializar DataTable
    var table = $('#tabla-color-talla').DataTable({
        "order": [[ 0, "asc" ]],
        "language": { "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" },
        "dom": '<"d-none"B>rtip', // Ocultamos los botones nativos para dispararlos nosotros
        "buttons": [
            { extend: 'excelHtml5', className: 'btn-export-excel', title: 'Reporte Stock Color Talla' },
            { extend: 'pdfHtml5', className: 'btn-export-pdf', title: 'Reporte Stock Color Talla' }
        ]
    });

    // Lógica de Filtros Personalizados
    $('#btn-aplicar').on('click', function() {
        table.column(0).search($('#filtro-modelo').val()); // Filtra Modelo
        table.column(1).search($('#filtro-color').val());  // Filtra Color
        table.column(2).search($('#filtro-talla').val());  // Filtra Talla
        table.draw();
    });

    $('#btn-limpiar').on('click', function() {
        $('#filtro-modelo, #filtro-color, #filtro-talla').val('');
        table.columns().search('').draw();
    });

    // Vincular tus botones de exportación a los de DataTables
    // Crearemos los botones visuales que pediste en la imagen
    let btnExcel = $('<button class="btn btn-success me-2 shadow-sm"><i class="fas fa-file-excel"></i> Exportar Excel</button>');
    let btnPdf = $('<button class="btn btn-primary shadow-sm" style="background-color: #5c6bc0; border:none;"><i class="fas fa-file-pdf"></i> Exportar PDF</button>');

    btnExcel.on('click', function() { table.button('.buttons-excel').trigger(); });
    btnPdf.on('click', function() { table.button('.buttons-pdf').trigger(); });

    $('#wrapper-botones').append(btnExcel).append(btnPdf);
});
</script>
@endsection