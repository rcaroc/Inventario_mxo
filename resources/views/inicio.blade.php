@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Encabezado del Panel --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">Panel de Control</h3>
        
        <div class="d-flex gap-2">
            {{-- BOTÓN ELIMINADO: Ahora la gestión se hace desde el menú superior --}}
        </div>
    </div>

    {{-- Fila de Tarjetas de Estadísticas --}}
    <div class="row">
        {{-- Tarjeta 1: Total Productos --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.75rem; opacity: 0.8;">Total Productos</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalProductos }}</h2>
                        </div>
                        <i class="fas fa-boxes fa-2x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 2: Stock Crítico --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-danger text-white shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.75rem; opacity: 0.8;">Stock Bajo</h6>
                            <h2 class="mb-0 fw-bold">{{ $stockBajo }}</h2>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 3: Entradas --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.75rem; opacity: 0.8;">Entradas Totales</h6>
                            <h2 class="mb-0 fw-bold">{{ $entradasHoy }}</h2>
                        </div>
                        <i class="fas fa-arrow-down fa-2x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 4: Salidas --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.75rem; opacity: 0.8;">Salidas Totales</h6>
                            <h2 class="mb-0 fw-bold">{{ $salidasHoy }}</h2>
                        </div>
                        <i class="fas fa-arrow-up fa-2x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Fila de Tabla de Movimientos --}}
    <div class="row mt-2">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-history me-2 text-primary"></i>Últimos Movimientos Registrados
                    </h5>
                    <a href="{{ route('movimientos.historial') }}" class="btn btn-outline-primary btn-sm">Ver Todo</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>Usuario Responsable</th>
                                    <th>Fecha y Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimosMovimientos as $mov)
                                <tr>
                                    <td class="fw-bold text-secondary">{{ $mov->producto->producto_nombre ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge rounded-pill {{ strtolower($mov->tipo) == 'entrada' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($mov->tipo) }}
                                        </span>
                                    </td>
                                    <td class="fw-bold {{ strtolower($mov->tipo) == 'entrada' ? 'text-success' : 'text-danger' }}">
                                        {{ strtolower($mov->tipo) == 'entrada' ? '+' : '-' }} {{ $mov->cantidad }}
                                    </td>
                                    <td>
                                        <i class="fas fa-user-circle me-1 text-muted"></i>
                                        {{ $mov->usuario->usuario_usuario ?? 'Sistema' }}
                                    </td>
                                    <td class="text-muted small">
                                        {{ $mov->created_at->format('d/m/Y') }} 
                                        <span class="ms-1 text-secondary opacity-75">{{ $mov->created_at->format('H:i') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="fas fa-folder-open fa-3x mb-3 d-block opacity-25"></i>
                                        No hay movimientos registrados en el sistema.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection