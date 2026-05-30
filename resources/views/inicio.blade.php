@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Tarjeta 1: Total Productos --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.8;">Productos</h6>
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
                            <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.8;">Stock Bajo</h6>
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
                            <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.8;">Entradas</h6>
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
                            <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.8;">Salidas</h6>
                            <h2 class="mb-0 fw-bold">{{ $salidasHoy }}</h2>
                        </div>
                        <i class="fas fa-arrow-up fa-2x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        {{-- Actividad Reciente --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-history me-2 text-primary"></i> Últimos Movimientos</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Tipo</th>
                                    <th>Cant.</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimosMovimientos as $mov)
                                <tr>
                                    {{-- Ajustado a producto_nombre --}}
                                    <td class="fw-bold">{{ $mov->producto->producto_nombre ?? 'N/A' }}</td>
                                    <td>
                                        {{-- Ajustado a 'tipo' según tu modelo --}}
                                        <span class="badge {{ strtolower($mov->tipo) == 'entrada' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $mov->tipo }}
                                        </span>
                                    </td>
                                    {{-- Ajustado a 'cantidad' según tu modelo --}}
                                    <td class="fw-bold {{ strtolower($mov->tipo) == 'entrada' ? 'text-success' : 'text-danger' }}">
                                        {{ strtolower($mov->tipo) == 'entrada' ? '+' : '-' }}{{ $mov->cantidad }}
                                    </td>
                                    <td>{{ $mov->usuario->usuario_nombre ?? 'Sistema' }}</td>
                                    <td class="text-muted small">{{ $mov->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">No se encontraron movimientos registrados.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Perfil rápido --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-3 h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->usuario_nombre }}+{{ Auth::user()->usuario_apellido }}&background=0d6efd&color=fff&size=128" 
                         class="rounded-circle mb-3 shadow-sm" width="100">
                    
                    <h4 class="fw-bold mb-1">{{ Auth::user()->usuario_nombre }} {{ Auth::user()->usuario_apellido }}</h4>
                    <p class="text-muted mb-3">{{ ucfirst(Auth::user()->rol) }}</p>
                    
                    <div class="badge {{ Auth::user()->rol == 'administrador' ? 'bg-danger' : 'bg-warning text-dark' }} mb-4 px-3 py-2">
                        Acceso Autorizado
                    </div>

                    <div class="d-grid gap-2 w-100">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-cog me-2"></i> Gestionar Usuarios
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-light border w-100">
                                <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection