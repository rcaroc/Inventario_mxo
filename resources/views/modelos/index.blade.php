@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    {{-- Título y Subtítulo --}}
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0" style="font-family: sans-serif;">Catálogo</h1>
        <p class="text-muted">Lista de Modelos</p>
    </div>

    {{-- CUADRO AZUL DE ÉXITO (Para cuando se elimine un modelo) --}}
    @if(session('eliminar') == 'ok')
    <div class="alert alert-primary border-0 shadow-sm mb-4" style="background-color: #f0f7ff; border-radius: 8px; padding: 20px; border-left: 5px solid #0056b3 !important;">
        <h5 class="fw-bold mb-1" style="color: #0056b3; letter-spacing: -0.5px;">¡MODELO ELIMINADO!</h5>
        <p class="mb-0" style="color: #0056b3; font-size: 0.95rem;">El modelo ha sido removido del catálogo con éxito</p>
    </div>
    @endif

    {{-- BARRA DE BÚSQUEDA (Exacta a tu imagen) --}}
    <form action="{{ route('modelos.index') }}" method="GET" class="mb-4">
        <div class="input-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
            <input type="text" name="buscar" class="form-control border-1 py-2" 
                   placeholder="Buscar por nombre o ubicación..." 
                   value="{{ request('buscar') }}" 
                   style="border-color: #dee2e6;">
            
            <button class="btn btn-primary px-4" type="submit" style="background-color: #3498db; border: none;">
                Buscar
            </button>
            
            <a href="{{ route('modelos.index') }}" class="btn btn-light border px-4" style="background-color: #f8f9fa;">
                Limpiar
            </a>
        </div>
    </form>

    {{-- TABLA DE MODELOS --}}
    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa; border-bottom: 2px solid #eee;">
                        <tr>
                            <th class="ps-4 py-3 fw-bold text-dark" style="font-size: 0.9rem;">Modelo</th>
                            <th class="py-3 fw-bold text-dark" style="font-size: 0.9rem;">Ubicación</th>
                            <th class="py-3 fw-bold text-dark text-center" style="font-size: 0.9rem;">Total productos</th>
                            <th class="py-3 fw-bold text-dark text-center" style="font-size: 0.9rem;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($modelos as $item)
                        <tr class="border-bottom">
                            <td class="ps-4 fw-bold text-dark">{{ $item->modelo_nombre }}</td>
                            <td>
                                <span class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $item->modelo_ubicacion }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-light text-dark border px-3">0</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- BOTÓN EDITAR --}}
                                    <a href="{{ route('modelos.edit', $item->modelo_id) }}" class="btn btn-sm btn-light border shadow-sm px-3">
                                        <i class="fas fa-edit text-secondary"></i>
                                    </a>
                                    
                                    {{-- FORMULARIO OCULTO PARA ELIMINAR --}}
                                    <form id="form-eliminar-{{ $item->modelo_id }}" action="{{ route('modelos.destroy', $item->modelo_id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    {{-- BOTÓN ELIMINAR CON SWEETALERT --}}
                                    <button type="button" class="btn btn-sm btn-danger shadow-sm px-3" onclick="confirmarEliminar({{ $item->modelo_id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 d-block opacity-25"></i>
                                No se encontraron modelos en el catálogo.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT PARA LA VENTANA "ESTÁ SEGURO?" --}}
<script>
function confirmarEliminar(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Este modelo se eliminará permanentemente del catálogo.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
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

<style>
    /* Estilos para igualar tu captura */
    .table thead th {
        letter-spacing: 0.2px;
    }
    .btn-primary {
        background-color: #3498db !important;
    }
    .btn-primary:hover {
        background-color: #2980b9 !important;
    }
    .table td {
        padding: 1rem 0.75rem;
    }
</style>
@endsection