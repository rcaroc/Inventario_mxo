@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Historial de Movimientos</h1>
        <p class="text-muted">Registro detallado de entradas y salidas de productos</p>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="ps-4 py-3 fw-bold text-dark">ID</th>
                            <th class="py-3 fw-bold text-dark">Tipo</th>
                            <th class="py-3 fw-bold text-dark">Producto</th>
                            <th class="py-3 fw-bold text-dark text-center">Cant.</th>
                            <th class="py-3 fw-bold text-dark">Usuario</th>
                            <th class="py-3 fw-bold text-dark">Descripción / Motivo</th>
                            <th class="py-3 fw-bold text-dark">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movimientos as $mov)
                        <tr class="border-bottom">
                            <td class="ps-4 fw-bold text-muted">#{{ $mov->movimiento_id }}</td>
                            <td>
                                @if($mov->tipo == 'entrada')
                                    <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3">
                                        Entrada
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-danger-subtle text-danger border border-danger-subtle px-3">
                                        Salida
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark">
                                    {{ $mov->producto->producto_nombre ?? 'Producto eliminado' }}
                                </div>
                            </td>
                            <td class="text-center fw-bold">
                                {{ $mov->cantidad }}
                            </td>
                            <td>
                                <span class="text-muted">
                                    {{ $mov->usuario->usuario_nombre ?? 'Admin' }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted italic">
                                    {{ $mov->descripcion ?? 'Sin descripción' }}
                                </small>
                            </td>
                            <td class="text-muted" style="font-size: 0.85rem;">
                                {{ $mov->created_at->format('Y-m-d H:i:s') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No hay movimientos registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection