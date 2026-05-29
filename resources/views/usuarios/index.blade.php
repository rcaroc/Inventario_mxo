@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Usuarios</h1>
        <p class="text-muted">Gestión de accesos al sistema</p>
    </div>

    {{-- Alertas de Éxito (Mismo estilo azul) --}}
    @if(session('eliminar') == 'ok')
        <div class="alert alert-primary border-0 shadow-sm mb-4" style="background-color: #f0f7ff; border-radius: 8px; padding: 20px; border-left: 5px solid #0056b3 !important;">
            <h5 class="fw-bold mb-1" style="color: #0056b3;">¡USUARIO ELIMINADO!</h5>
            <p class="mb-0" style="color: #0056b3;">El usuario ha sido removido correctamente.</p>
        </div>
    @endif

    @if(session('actualizado') == 'ok')
        <div class="alert alert-primary border-0 shadow-sm mb-4" style="background-color: #f0f7ff; border-radius: 8px; padding: 20px; border-left: 5px solid #0056b3 !important;">
            <h5 class="fw-bold mb-1" style="color: #0056b3;">¡USUARIO ACTUALIZADO!</h5>
            <p class="mb-0" style="color: #0056b3;">Los datos del usuario se actualizaron con éxito.</p>
        </div>
    @endif

    {{-- Tabla de Usuarios --}}
    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="ps-4 py-3 fw-bold text-dark">Nombre</th>
                            <th class="py-3 fw-bold text-dark">Correo Electrónico</th>
                            <th class="py-3 fw-bold text-dark">Rol</th>
                            <th class="py-3 fw-bold text-dark text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $user)
                        <tr class="border-bottom">
                            <td class="ps-4 fw-bold text-dark">{{ $user->name }}</td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-light text-dark border px-3">
                                    {{ $user->rol ?? 'Usuario' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    
                                    {{-- BOTÓN EDITAR ESTILO IMAGEN --}}
                                    <a href="{{ route('usuarios.edit', $user->id) }}" class="btn-editar-custom">
                                        Editar
                                    </a>
                                    
                                    {{-- FORMULARIO PARA ELIMINAR --}}
                                    <form id="form-eliminar-{{ $user->id }}" action="{{ route('usuarios.destroy', $user->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    {{-- BOTÓN ELIMINAR ESTILO IMAGEN --}}
                                    <button type="button" class="btn-eliminar-custom" onclick="confirmarEliminar({{ $user->id }})">
                                        Eliminar
                                    </button>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarEliminar(id) {
    Swal.fire({
        title: '¿Eliminar usuario?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef5350',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-eliminar-' + id).submit();
        }
    })
}
</script>
@endsection