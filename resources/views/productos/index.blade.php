@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="fw-bold text-dark mb-0">Productos</h1>
            <p class="text-muted">Lista de productos registrados</p>
        </div>
        {{-- Botón "Nuevo Producto" eliminado de aquí según tu solicitud --}}
    </div>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-primary border-0 shadow-sm mb-4" style="background-color: #f0f7ff; border-radius: 8px; padding: 20px; border-left: 5px solid #0056b3 !important;">
            <h5 class="fw-bold mb-1" style="color: #0056b3;">¡LOGRADO!</h5>
            <p class="mb-0" style="color: #0056b3;">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 8px; padding: 20px;">
            <h5 class="fw-bold mb-1">ERROR</h5>
            <p class="mb-0">{{ session('error') }}</p>
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="ps-4 py-3 fw-bold text-dark" style="width: 40%;">Producto</th>
                            <th class="py-3 fw-bold text-dark text-center">Talla</th>
                            <th class="py-3 fw-bold text-dark text-center">Color</th>
                            <th class="py-3 fw-bold text-dark text-center">Stock</th>
                            <th class="py-3 fw-bold text-dark text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $prod)
                        <tr class="border-bottom">
                            <td class="ps-4">
                                <span class="text-dark">{{ $prod->producto_nombre }}</span>
                            </td>
                            <td class="text-center text-muted">
                                {{ $prod->producto_talla }}
                            </td>
                            <td class="text-center text-muted">
                                {{ $prod->producto_color }}
                            </td>
                            <td class="text-center">
                                {{-- Mostramos el stock real desde la tabla relacionada --}}
                                <span class="fw-bold {{ ($prod->stock->cantidad ?? 0) > 0 ? 'text-primary' : '' }}">
                                    {{ $prod->stock->cantidad ?? 0 }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    {{-- LÓGICA: Si tiene stock > 0, el botón se desactiva --}}
                                    @if(($prod->stock->cantidad ?? 0) > 0)
                                        <button type="button" class="btn-eliminar-custom disabled" 
                                                style="opacity: 0.5; cursor: not-allowed; filter: grayscale(1);" 
                                                title="No se puede eliminar un producto con stock" disabled>
                                            Bloqueado
                                        </button>
                                    @else
                                        <form id="form-eliminar-{{ $prod->producto_id }}" action="{{ route('productos.destroy', $prod->producto_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-eliminar-custom" onclick="confirmarEliminar({{ $prod->producto_id }})">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No hay productos registrados.</td>
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
        title: '¿Estás seguro?',
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