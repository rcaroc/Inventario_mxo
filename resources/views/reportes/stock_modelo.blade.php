@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    .btn-export-pdf { background-color: #5dade2; color: white; border-radius: 4px; border: none; padding: 6px 15px; }
    .btn-export-excel { background-color: #52be80; color: white; border-radius: 4px; border: none; padding: 6px 15px; }
    .btn-export-pdf:hover { background-color: #3498db; color: white; }
    .btn-export-excel:hover { background-color: #27ae60; color: white; }
    table.dataTable thead th { border-bottom: 1px solid #dee2e6 !important; }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Reporte de Stock por Modelo</h1>
    </div>

    <div class="mb-4">
        <button class="btn-export-pdf me-2"><i class="fas fa-file-pdf"></i> Exportar PDF</button>
        <button class="btn-export-excel"><i class="fas fa-file-excel"></i> Exportar Excel</button>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <table id="tabla-reporte-modelo" class="table table-hover align-middle">
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
                        <td class="text-muted">{{ $item->ubicacion ?? '---' }}</td>
                        <td class="text-center">{{ $item->productos_count }}</td>
                        <td class="text-center fw-bold {{ $item->stock_total <= 5 ? 'text-danger' : '' }}">
                            {{ $item->stock_total ?? 0 }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-top">
                    <tr class="fw-bold">
                        <td colspan="3" class="text-end">Total general</td>
                        <td class="text-center text-primary fs-5">{{ $totalGeneral }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tabla-reporte-modelo').DataTable({
            "pageLength": 10,
            "order": [[ 3, "desc" ]], // Ordenar por Stock Total (columna 3) de mayor a menor
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "drawCallback": function( settings ) {
                // Esto es para que el pie de página (footer) no se pierda al filtrar
                console.log('Tabla redibujada');
            }
        });
    });
</script>
@endsection