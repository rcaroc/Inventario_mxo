@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Catálogo</h1>
        <p class="text-muted">Lista de Modelos</p>
    </div>

    {{-- Alertas de Éxito --}}
    @if(session('eliminar') == 'ok')
        <div class="alert alert-primary border-0 shadow-sm mb-4" style="background-color: #f0f7ff; border-radius: 8px; padding: 20px; border-left: 5px solid #0056b3 !important;">
            <h5 class="fw-bold mb-1" style="color: #0056b3;">¡MODELO ELIMINADO!</h5>
            <p class="mb-0" style="color: #0056b3;">El modelo ha sido removido del catálogo con éxito</p>
        </div>
    @endif

    @if(session('actualizado') == 'ok')
        <div class="alert alert-primary border-0 shadow-sm mb-4" style="background-color: #f0f7ff; border-radius: 8px; padding: 20px; border-left: 5px solid #0056b3 !important;">
            <h5 class="fw-bold mb-1" style="color: #0056b3;">¡MODELO ACTUALIZADO!</h5>
            <p class="mb-0" style="color: #0056b3;">Los cambios se guardaron correctamente</p>
        </div>
    @endif

    <form action="{{ route('modelos.index') }}" method="GET" class="mb-4">
        <div class="input-group shadow-sm">
            <input type="text" name="buscar" class="form-control border-1 py-2" placeholder="Buscar por nombre o ubicación..." value="{{ request('buscar') }}">
            <button class="btn btn-primary px-4" type="submit" style="background-color: #3498db; border: none;">Buscar</button>
            <a href="{{ route('modelos.index') }}" class="btn btn-light border px-4">Limpiar</a>
        </div>
    </form>

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="ps-4 py-3 fw-bold text-dark">Modelo</th>
                            <th class="py-3 fw-bold text-dark">Ubicación</th>
                            <th class="py-3 fw-bold text-dark text-center">Total productos</th>
                            <th class="py-3 fw-bold text-dark text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($modelos as $item)
                        <tr class="border-bottom">
                            <td class="ps-4 fw-bold text-dark">{{ $item->modelo_nombre }}</td>
                            <td>
                                {{-- ICONO ELIMINADO AQUÍ --}}
                                <span class="text-muted">{{ $item->modelo_ubicacion ?? 'Sin ubicación' }}</span>
                            </td>
                            <td class="text-center"><span class="badge bg-light text-dark border px-3">0</span></td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('modelos.edit', $item->modelo_id) }}" class="btn btn-sm btn-light border shadow-sm px-3">
                                        <i class="fas fa-edit text-secondary"></i>
                                    </a>
                                    
                                    <form id="form-eliminar-{{ $item->modelo_id }}" action="{{ route('modelos.destroy', $item->modelo_id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    <button type="button" class="btn btn-sm btn-danger shadow-sm px-3" onclick="confirmarEliminar({{ $item->modelo_id }})">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-5 text-muted">No se encontraron modelos.</td></tr>
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
        title: '¿Estás seguro?',
        text: "Este modelo se eliminará permanentemente.",
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
@endsection