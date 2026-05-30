@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    .btn-export-pdf { background-color: #5dade2; color: white; border-radius: 4px; border: none; padding: 7px 18px; font-size: 14px; font-weight: 500; }
    .btn-export-excel { background-color: #48c78e; color: white; border-radius: 4px; border: none; padding: 7px 18px; font-size: 14px; font-weight: 500; }
    .btn-export-pdf:hover { background-color: #3498db; }
    .btn-export-excel:hover { background-color: #3ead76; }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Reporte de Stock por Modelo</h1>
    </div>

    <div class="mb-4">
        <button class="btn-export-pdf me-2 shadow-sm"><i class="fas fa-file-pdf me-1"></i> Exportar PDF</button>
        <button class="btn-export-excel shadow-sm"><i class="fas fa-file-excel me-1"></i> Exportar Excel</button>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="table-responsive">
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
                            <td class="fw-bold text-dark">{{ $item->modelo_nombre }}</td>
                            <td class="text-muted">{{ $item->ubicacion ?? '---' }}</td>
                            <td class="text-center">{{ $item->productos_count }}</td>
                            <td class="text-center fw-bold">
                                <span class="{{ $item->stock_total <= 0 ? 'text-danger' : 'text-dark' }}">
                                    {{ $item->stock_total ?? 0 }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-top">
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end py-3">Total general</td>
                            <td class="text-center py-3 fs-5 text-primary">{{ $totalGeneral }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
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
            "order": [[ 3, "desc" ]], // Ordenar por Stock total de mayor a menor
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            "pageLength": 10,
            "dom": '<"d-flex justify-content-between align-items-center mb-3"lf>rtip' 
        });
    });
</script>
@endsection