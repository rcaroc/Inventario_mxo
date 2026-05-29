@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    {{-- MENSAJE DE ÉXITO (EL CUADRO AZUL DE TU IMAGEN) --}}
    @if(session('eliminar') == 'ok')
    <div class="alert alert-primary border-0 shadow-sm mb-4" style="background-color: #f0f7ff; border-radius: 8px; padding: 20px; border-left: 5px solid #0056b3 !important;">
        <h5 class="fw-bold mb-1" style="color: #0056b3; letter-spacing: -0.5px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">¡USUARIO ELIMINADO!</h5>
        <p class="mb-0" style="color: #0056b3; font-size: 0.95rem;">Los datos del usuario se eliminaron con éxito</p>
    </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-bold text-dark">
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
                            <td class="text-dark fw-bold">{{ $user->usuario_usuario }}</td>
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
                                <span class="badge shadow-sm px-3 py-2" style="{{ $badgeColor }} border-radius: 6px; font-size: 0.75rem; min-width: 110px;">
                                    {{ strtoupper($user->rol) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($user->usuario_id == 1 || $rolLower == 'administrador')
                                    <span class="badge bg-light text-secondary border px-3 py-2" style="border-radius: 6px;">
                                        <i class="fas fa-lock me-1"></i> Usuario actual
                                    </span>
                                @else
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- BOTÓN EDITAR --}}
                                        <a href="{{ route('usuarios.edit', $user->usuario_id) }}" class="btn btn-sm btn-light border shadow-sm px-3">
                                            <i class="fas fa-edit text-dark"></i>
                                        </a>
                                        
                                        {{-- FORMULARIO OCULTO PARA ELIMINAR --}}
                                        <form id="form-eliminar-{{ $user->usuario_id }}" action="{{ route('usuarios.destroy', $user->usuario_id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        {{-- BOTÓN ELIMINAR QUE ACTIVA EL SWEETALERT --}}
                                        <button type="button" class="btn btn-sm btn-danger shadow-sm px-3" onclick="confirmarEliminacion({{ $user->usuario_id }})">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No hay usuarios registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card-footer bg-white border-top-0 py-3 text-end">
            <p class="small text-muted mb-0">Total: <strong>{{ count($usuarios) }}</strong> registrados.</p>
        </div>
    </div>
</div>

{{-- SCRIPTS PARA SWEETALERT2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmarEliminacion(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡Esta acción eliminará al usuario permanentemente!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Enviar el formulario oculto correspondiente
                document.getElementById('form-eliminar-' + id).submit();
            }
        })
    }
</script>

<style>
    .table td, .table th { padding: 1.2rem 0.75rem; }
    .table tbody tr:hover { background-color: #fafafa; transition: 0.2s; }
    .btn-danger { background-color: #dc3545; border: none; }
    .btn-danger:hover { background-color: #bb2d3b; }
</style>
@endsection