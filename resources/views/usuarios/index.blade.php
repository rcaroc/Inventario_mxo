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
                                <span class="text-primary fw-bold">@</span>{{ $user->usuario_usuario }}
                            </td>
                            <td>
                                {{-- Lógica de Badges por Rol con colores específicos --}}
                                @php
                                    $rolLower = strtolower($user->rol);
                                    $badgeColor = match($rolLower) {
                                        'administrador' => 'background-color: #dc3545; color: white;', // Rojo
                                        'inventario'    => 'background-color: #ffc107; color: #000;',   // Amarillo/Dorado
                                        'ventas'        => 'background-color: #198754; color: white;', // Verde
                                        default         => 'background-color: #6c757d; color: white;'
                                    };
                                @endphp
                                <span class="badge shadow-sm px-3 py-2" style="{{ $badgeColor }} border-radius: 6px; font-size: 0.75rem; min-width: 100px;">
                                    {{ strtoupper($user->rol) }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{-- Bloqueo para Usuario Principal o Rol Administrador --}}
                                @if($user->usuario_id == 1 || $rolLower == 'administrador')
                                    <span class="badge bg-light text-secondary border px-3 py-2" style="border-radius: 6px;">
                                        <i class="fas fa-lock me-1"></i> Usuario actual
                                    </span>
                                @else
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Botón Editar --}}
                                        <a href="#" class="btn btn-sm btn-light border shadow-sm" title="Editar">
                                            <i class="fas fa-edit text-dark"></i>
                                        </a>
                                        {{-- Botón Eliminar Sólido --}}
                                        <form action="#" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger shadow-sm px-3" title="Eliminar">
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
                                <p class="mb-0">No hay usuarios registrados en el sistema.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top-0 py-3">
            <p class="small text-muted mb-0">Total: <strong>{{ count($usuarios) }}</strong> usuarios en el sistema.</p>
        </div>
    </div>
</div>

<style>
    /* Espaciado generoso en las celdas */
    .table td, .table th {
        padding: 1.2rem 0.75rem;
    }
    /* Efecto sutil al pasar el mouse */
    .table tbody tr:hover {
        background-color: #fafafa;
        transition: background-color 0.2s ease;
    }
    /* Bordes redondeados sutiles para los badges */
    .badge {
        font-weight: 600;
        letter-spacing: 0.3px;
    }
</style>
@endsection