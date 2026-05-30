@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Reporte de Stock por Modelo</h1>
    </div>

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
                    <tfoot class="table-light border-top">
                        <tr class="fw-bold text-dark">
                            {{-- Ocupamos 3 columnas para que el total se alinee con el stock --}}
                            <td colspan="3" class="text-end py-3">Total general</td>
                            {{-- Esta es la celda donde DataTables inyectará el resultado --}}
                            <td class="text-center py-3 fs-5 text-primary"></td> 
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
    var table = $('#tabla-stock-modelo').DataTable({
        "order": [[ 0, "asc" ]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        // 'B' renderiza los botones, 'f' el buscador
        "dom": '<"d-flex justify-content-between align-items-center mb-3"Bf>rt<"d-flex justify-content-between"ip>', 
        "buttons": [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel me-1"></i> Exportar Excel',
                className: 'btn-export-excel shadow-sm me-2',
                title: 'Reporte Stock por Modelo',
                footer: true // Para que el total salga en el Excel
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf me-1"></i> Exportar PDF',
                className: 'btn-export-pdf shadow-sm',
                title: 'Reporte Stock por Modelo',
                footer: true // Para que el total salga en el PDF
            }
        ],
        // FUNCIÓN PARA SUMAR EL TOTAL AUTOMÁTICAMENTE
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api();

            // Quitar formato para sumar
            var intVal = function (i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ? i : 0;
            };

            // Total de la columna 3 (Stock total)
            total = api
                .column(3, { page: 'current'} )
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Actualizar la celda del footer
            $(api.column(3).footer()).html(total);
        }
    });
});
</script>
@endsection