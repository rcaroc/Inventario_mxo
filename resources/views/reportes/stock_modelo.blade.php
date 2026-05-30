@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Reporte de Stock por Modelo</h1>
    </div>

    {{-- Contenedor donde aparecerán los botones de exportación --}}
    <div id="contenedor-botones" class="mb-3"></div>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tabla-stock-modelo" class="table table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>Modelo</th>
                            <th>Ubicación</th>
                            <th class="text-center">Productos</th>
                            <th class="text-center">Stock total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reporte as $item)
                        <tr>
                            <td class="fw-bold">{{ $item->modelo_nombre }}</td>
                            <td class="text-muted">{{ $item->modelo_ubicacion ?? '---' }}</td>
                            <td class="text-center">{{ $item->productos_count }}</td>
                            <td class="text-center fw-bold">
                                <span class="{{ ($item->stock_total ?? 0) <= 0 ? 'text-danger' : '' }}">
                                    {{ $item->stock_total ?? 0 }}
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
    var table = $('#tabla-stock-modelo').DataTable({
        "order": [[ 0, "asc" ]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        // Añadimos 'B' al inicio para que renderice los Buttons
        "dom": '<"d-flex justify-content-between align-items-center"Bf>rt<"d-flex justify-content-between"ip>', 
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Exportar Excel',
                className: 'btn-export-excel shadow-sm me-2',
                title: 'Reporte Stock por Modelo'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf me-1"></i> Exportar PDF',
                className: 'btn-export-pdf shadow-sm',
                title: 'Reporte Stock por Modelo'
            }
        ]
    });

    // Esta línea ya no es necesaria si usamos la 'B' en el dom, 
    // pero la dejamos comentada por si quieres moverlos manualmente después.
    // table.buttons().container().appendTo('#contenedor-botones');
});
</script>
@endsection