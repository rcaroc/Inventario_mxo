@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Productos</h1>
        <p class="text-muted">Lista de productos registrados</p>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="ps-4 py-3 fw-bold text-dark">Producto </th>
                            <th class="py-3 fw-bold text-dark text-center">Talla</th>
                            <th class="py-3 fw-bold text-dark text-center">Color</th>
                            <th class="py-3 fw-bold text-dark text-center">Stock</th>
                            <th class="py-3 fw-bold text-dark text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $prod)
                        <tr class="border-bottom">
                            <td class="ps-4 fw-bold text-dark">
                                {{ $prod->modelo->modelo_nombre }}
                            </td>
                            <td class="text-center">{{ $prod->talla }}</td>
                            <td class="text-center">{{ $prod->color }}</td>
                            <td class="text-center">
                                <span class="fw-bold {{ $prod->stock > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $prod->stock }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Botón Eliminar Estilo Imagen --}}
                                    <form action="{{ route('productos.destroy', $prod->producto_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-eliminar-custom">
                                            Eliminar
                                        </button>
                                    </form>
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
@endsection