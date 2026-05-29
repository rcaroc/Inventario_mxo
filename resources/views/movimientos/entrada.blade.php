@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Movimientos</h1>
        <p class="text-muted">Registrar entrada</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('movimientos.storeEntrada') }}" method="POST">
        @csrf
        <div class="row g-3">
            {{-- Modelo --}}
            <div class="col-md-5">
                <label class="form-label fw-bold">Modelo</label>
                <select id="select-modelo" class="form-select py-2">
                    <option value="" selected disabled>Seleccione un modelo...</option>
                    @foreach($modelos as $m)
                        <option value="{{ $m->modelo_id }}">{{ $m->modelo_nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Producto --}}
            <div class="col-md-7">
                <label class="form-label fw-bold">Producto (variante)</label>
                <select name="producto_id" id="select-producto" class="form-select py-2" disabled required>
                    <option value="" selected disabled>Seleccione un producto...</option>
                </select>
                <small class="text-muted">Un producto representa una variante (Color/Talla) dentro del modelo seleccionado.</small>
            </div>
        </div>

        {{-- Banner de Stock Actual (Dinámico) --}}
        <div class="row mt-3">
            <div class="col-12">
                <div id="stock-banner" class="alert alert-info border-0 py-3 d-none" style="background-color: #f0f4ff; color: #3056d3;">
                    <span class="fw-bold">Stock actual del producto: </span>
                    <span id="stock-count">0</span>
                </div>
            </div>
        </div>

        {{-- Cantidad y Descripción --}}
        <div class="row mt-3 g-3">
            <div class="col-md-4">
                <label class="form-label fw-bold">Cantidad (unidades)</label>
                <input type="number" name="cantidad" class="form-control py-2" min="1" placeholder="Ej: 10" required>
            </div>
            <div class="col-md-8">
                <label class="form-label fw-bold">Descripción (opcional)</label>
                <input type="text" name="descripcion" class="form-control py-2" placeholder="Ej: Compra a proveedor, corrección de inventario, etc.">
            </div>
        </div>

        {{-- Botón Registrar --}}
        <div class="row mt-4">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-success px-5 py-2" style="background-color: #48bb78; border: none; border-radius: 30px;">
                    Registrar entrada
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('select-modelo').addEventListener('change', function() {
    const modeloId = this.value;
    const selectProducto = document.getElementById('select-producto');
    const stockBanner = document.getElementById('stock-banner');
    
    selectProducto.disabled = true;
    stockBanner.classList.add('d-none');

    fetch(`/api/productos-por-modelo/${modeloId}`)
        .then(response => response.json())
        .then(data => {
            selectProducto.innerHTML = '<option value="" selected disabled>Seleccione un producto...</option>';
            data.forEach(prod => {
                const option = document.createElement('option');
                option.value = prod.producto_id;
                // Guardamos el stock en un atributo data para usarlo luego
                option.dataset.stock = prod.stock ? prod.stock.cantidad : 0;
                option.textContent = `${prod.producto_nombre}`;
                selectProducto.appendChild(option);
            });
            selectProducto.disabled = false;
        });
});

// Mostrar el stock actual al cambiar de producto
document.getElementById('select-producto').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const stockCount = document.getElementById('stock-count');
    const stockBanner = document.getElementById('stock-banner');

    stockCount.textContent = selectedOption.dataset.stock;
    stockBanner.classList.remove('d-none');
});
</script>
@endsection