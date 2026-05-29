@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Movimientos</h1>
        <p class="text-muted">Registrar entrada de inventario</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('movimientos.storeEntrada') }}" method="POST">
        @csrf
        <div class="row g-3">
            {{-- 1. Selector de Modelo --}}
            <div class="col-md-5">
                <label class="form-label fw-bold">Modelo</label>
                <select id="select-modelo" class="form-select py-2">
                    <option value="" selected disabled>Seleccione un modelo...</option>
                    @foreach($modelos as $m)
                        <option value="{{ $m->modelo_id }}">{{ $m->modelo_nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 2. Selector de Producto --}}
            <div class="col-md-7">
                <label class="form-label fw-bold">Producto (variante)</label>
                <select name="producto_id" id="select-producto" class="form-select py-2" disabled required>
                    <option value="" selected disabled>Seleccione un producto...</option>
                </select>
                <small class="text-muted">Seleccione modelo para habilitar las variantes.</small>
            </div>
        </div>

        {{-- SECCIÓN OCULTA: Solo aparece cuando se selecciona el producto --}}
        <div id="seccion-detalles" class="d-none animate__animated animate__fadeIn">
            
            {{-- Banner de Stock Actual --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div id="stock-banner" class="alert alert-info border-0 py-3" style="background-color: #f0f4ff; color: #3056d3; border-left: 5px solid #3056d3 !important;">
                        <span class="fw-bold">Stock actual del producto: </span>
                        <span id="stock-count" class="fs-5">0</span>
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

            {{-- Botón de Registro --}}
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-success px-5 py-2" style="background-color: #48bb78; border: none; border-radius: 30px; font-weight: bold;">
                        Registrar entrada
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.getElementById('select-modelo').addEventListener('change', function() {
    const modeloId = this.value;
    const selectProducto = document.getElementById('select-producto');
    const seccionDetalles = document.getElementById('seccion-detalles');
    
    // Resetear y bloquear producto si cambia el modelo
    selectProducto.disabled = true;
    seccionDetalles.classList.add('d-none');
    
    fetch(`/api/productos-por-modelo/${modeloId}`)
        .then(response => response.json())
        .then(data => {
            selectProducto.innerHTML = '<option value="" selected disabled>Seleccione un producto...</option>';
            data.forEach(prod => {
                const option = document.createElement('option');
                option.value = prod.producto_id;
                // Guardamos el stock dinámico de la relación
                option.dataset.stock = prod.stock ? prod.stock.cantidad : 0;
                option.textContent = prod.producto_nombre;
                selectProducto.appendChild(option);
            });
            selectProducto.disabled = false;
        });
});

// Mostrar detalles solo cuando se elige el producto final
document.getElementById('select-producto').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const stockCount = document.getElementById('stock-count');
    const seccionDetalles = document.getElementById('seccion-detalles');

    if (this.value) {
        stockCount.textContent = selectedOption.dataset.stock;
        seccionDetalles.classList.remove('d-none'); // MOSTRAR el resto del formulario
    } else {
        seccionDetalles.classList.add('d-none');
    }
});
</script>
@endsection