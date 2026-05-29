@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold text-dark mb-0">Productos</h1>
            <p class="text-muted">Lista de productos registrados</p>
        </div>
        {{-- Botón para ir a crear nuevo --}}
        <a href="{{ route('productos.create') }}" class="btn btn-primary px-4" style="background-color: #3498db; border: none; border-radius: 8px;">
            + Nuevo Producto
        </a>
    </div>

    {{-- Alerta de éxito al eliminar o crear --}}
    @if(session('success'))
        <div class="alert alert-primary border-0 shadow-sm mb-4" style="background-color: #f0f7ff; border-radius: 8px; padding: 20px; border-left: 5px solid #0056b3 !important;">
            <h5 class="fw-bold mb-1" style="color: #0056b3;">¡LOGRADO!</h5>
            <p class="mb-0" style="color: #0056b3;">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('eliminar') == 'ok')
        <div class="alert alert-primary border-0 shadow-sm mb-4" style="background-color: #f0f7ff; border-radius: 8px; padding: 20px; border-left: 5px solid #0056b3 !important;">
            <h5 class="fw-bold mb-1" style="color: #0056b3;">¡PRODUCTO ELIMINADO!</h5>
            <p class="mb-0" style="color: #0056b3;">El registro ha sido borrado correctamente.</p>
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="ps-4 py-3 fw-bold text-dark">Producto</th>
                            <th class="py-3 fw-bold text-dark text-center">Talla</th>
                            <th class="py-3 fw-bold text-dark text-center">Color</th>
                            <th class="py-3 fw-bold text-dark text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $prod)
                        <tr class="border-bottom">
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $prod->producto_nombre }}</div>
                                <small class="text-muted">ID: #{{ $prod->producto_id }}</small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-3">
                                    {{ $prod->producto_talla ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-muted text-uppercase" style="font-size: 0.9rem;">
                                    {{ $prod->producto_color ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    
                                    {{-- FORMULARIO PARA ELIMINAR --}}
                                    <form id="form-eliminar-{{ $prod->producto_id }}" action="{{ route('productos.destroy', $prod->producto_id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                    {{-- BOTÓN ELIMINAR ESTILO IMAGEN --}}
                                    <button type="button" class="btn-eliminar-custom" onclick="confirmarEliminar({{ $prod->producto_id }})">
                                        Eliminar
                                    </button>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open d-block mb-2" style="font-size: 2rem;"></i>
                                No hay productos registrados aún.
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
        title: '¿Eliminar producto?',
        text: "Esta variante se borrará de la lista permanentemente.",
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