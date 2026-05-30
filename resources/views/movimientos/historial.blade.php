@extends('layouts.app')

@section('css')
{{-- Estilos de DataTables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    .badge-entrada { background-color: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
    .badge-salida { background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #4a5568 !important; color: white !important; border: none;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Historial de Movimientos</h1>
        <p class="text-muted">Registro detallado de entradas y salidas de productos</p>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tabla-movimientos" class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="fw-bold">ID</th>
                            <th class="fw-bold">Tipo</th>
                            <th class="fw-bold">Producto</th>
                            <th class="fw-bold text-center">Cant.</th>
                            <th class="fw-bold">Usuario</th>
                            <th class="fw-bold">Descripción / Motivo</th>
                            <th class="fw-bold">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimientos as $mov)
                        <tr>
                            <td class="text-muted fw-bold">#{{ $mov->movimiento_id }}</td>
                            <td>
                                @if($mov->tipo == 'entrada')
                                    <span class="badge rounded-pill badge-entrada px-3">Entrada</span>
                                @else
                                    <span class="badge rounded-pill badge-salida px-3">Salida</span>
                                @endif
                            </td>
                            <td class="fw-bold text-dark">
                                {{ $mov->producto->producto_nombre ?? 'N/A' }}
                            </td>
                            <td class="text-center fw-bold">
                                {{ $mov->tipo == 'salida' ? '-' : '+' }}{{ $mov->cantidad }}
                            </td>
                            <td class="text-muted">
                                {{ $mov->usuario->usuario_nombre ?? 'Admin' }}
                            </td>
                            <td>
                                <small class="text-secondary">{{ $mov->descripcion ?? '---' }}</small>
                            </td>
                            <td class="text-muted">
                                {{ $mov->created_at->format('Y-m-d H:i:s') }}
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
{{-- Scripts de jQuery y DataTables --}}
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#tabla-movimientos').DataTable({
        "order": [[ 0, "desc" ]], // Inicia ordenando por ID de mayor a menor
        "pageLength": 10,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron movimientos",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate": {
                "next": "Siguiente",
                "previous": "Anterior"
            }
        }
    });
});
</script>
@endsection