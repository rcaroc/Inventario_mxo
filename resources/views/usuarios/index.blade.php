@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-bold text-dark" style="letter-spacing: -0.5px;">
                <i class="fas fa-users me-2 text-secondary"></i>Lista de Usuarios
            </h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                {{-- AQUÍ EMPIEZA LA TABLA --}}
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-secondary small fw-bold" style="width: 50px;">#</th>
                            <th class="py-3 text-uppercase text-secondary small fw-bold">Nombres</th>
                            <th class="py-3 text-uppercase text-secondary small fw-bold">Apellidos</th>
                            <th class="py-3 text-uppercase text-secondary small fw-bold">Usuario</th>
                            <th class="py-3 text-uppercase text-secondary small fw-bold">Rol</th>
                            <th class="py-3 text-uppercase text-secondary small fw-bold text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $user)
                        <tr class="border-bottom">
                            <td class="ps-4 fw-bold text-muted">{{ $user->usuario_id }}</td>
                            <td class="fw-medium text-dark">{{ $user->usuario_nombre }}</td>
                            <td class="text-dark">{{ $user->usuario_apellido }}</td>
                            <td>
                                <td>
    <span class="text-dark">{{ $user->usuario_usuario }}</span>
</td>
                            </td>
                            <td>
                                @php
                                    $rolLower = strtolower($user->rol);
                                    $badgeColor = match($rolLower) {
                                        'administrador' => 'background-color: #dc3545; color: white;',
                                        'inventario'    => 'background-color: #ffc107; color: #000;',
                                        'ventas'        => 'background-color: #198754; color: white;',
                                        default         => 'background-color: #6c757d; color: white;'
                                    };
                                @endphp
                                <span class="badge shadow-sm px-3 py-2" style="{{ $badgeColor }} border-radius: 6px; font-size: 0.75rem; min-width: 100px;">
                                    {{ strtoupper($user->rol) }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{-- Bloqueo de seguridad para el ID 1 o rol administrador --}}
                                @if($user->usuario_id == 1 || $rolLower == 'administrador')
                                    <span class="badge bg-light text-secondary border px-3 py-2" style="border-radius: 6px;">
                                        <i class="fas fa-lock me-1"></i> Usuario actual
                                    </span>
                                @else
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="#" class="btn btn-sm btn-light border shadow-sm">
                                            <i class="fas fa-edit text-dark"></i>
                                        </a>
                                        <form action="#" method="POST" onsubmit="return confirm('¿Eliminar usuario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger shadow-sm px-3">
                                                <i class="fas fa-trash-alt me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top-0 py-3">
            <p class="small text-muted mb-0">Total: <strong>{{ count($usuarios) }}</strong> usuarios.</p>
        </div>
    </div>
</div>

<style>
    .table td, .table th { padding: 1.2rem 0.75rem; }
    .table tbody tr:hover { background-color: #fafafa; }
</style>
@endsection