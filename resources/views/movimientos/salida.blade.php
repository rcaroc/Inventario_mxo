@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Movimientos</h1>
        <p class="text-danger fw-bold">Registrar salida de inventario</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    {{-- Banner de ATENCIÓN (Se activa por JS) --}}
    <div id="alert-insuficiente" class="alert alert-warning border-0 shadow-sm d-none mb-4" style="border-left: 5px solid #ffc107 !important;">
        <div class="d-flex align-items-center">
            <span class="fs-4 me-3">⚠️</span>
            <div>
                <h6 class="fw-bold mb-0">¡ATENCIÓN!</h6>
                <span>No hay stock suficiente para registrar la salida solicitada. Stock disponible: <strong id="stock-disponible-msg">0</strong>.</span>
            </div>
        </div>
    </div>

    <form action="{{ route('movimientos.storeSalida') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label fw-bold">Modelo</label>
                <select id="select-modelo" class="form-select py-2">
                    <option value="" selected disabled>Seleccione un modelo...</option>
                    @foreach($modelos as $m)
                        <option value="{{ $m->modelo_id }}">{{ $m->modelo_nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-7">
                <label class="form-label fw-bold">Producto (variante con stock)</label>
                <select name="producto_id" id="select-producto" class="form-select py-2" disabled required>
                    <option value="" selected disabled>Seleccione un modelo primero...</option>
                </select>
            </div>
        </div>

        <div id="seccion-detalles" class="d-none">
            <div class="row mt-4">
                <div class="col-12">
                    <div id="stock-banner" class="alert border-0 py-3" style="background-color: #fff5f5; color: #c53030; border-left: 5px solid #c53030 !important;">
                        <span class="fw-bold">Stock disponible para retiro: </span>
                        <span id="stock-count" class="fs-5">0</span>
                    </div>
                </div>
            </div>

            <div class="row mt-3 g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Cantidad a retirar</label>
                    <input type="number" name="cantidad" id="input-cantidad" class="form-control py-2" min="1" required>
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-bold">Descripción / Motivo</label>
                    <input type="text" name="descripcion" class="form-control py-2" placeholder="Venta, merma, etc.">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button type="submit" id="btn-submit" class="btn btn-danger px-5 py-2" style="border-radius: 30px; font-weight: bold;">
                        Registrar salida
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
let stockMaximo = 0;

document.getElementById('select-modelo').addEventListener('change', function() {
    const modeloId = this.value;
    const selectProducto = document.getElementById('select-producto');
    const seccionDetalles = document.getElementById('seccion-detalles');
    
    selectProducto.disabled = true;
    seccionDetalles.classList.add('d-none');
    
    // Llamamos a la API con el filtro de stock
    fetch(`/api/productos-por-modelo/${modeloId}?con_stock=1`)
        .then(response => response.json())
        .then(data => {
            selectProducto.innerHTML = '<option value="" selected disabled>Seleccione variante...</option>';
            if(data.length === 0) {
                selectProducto.innerHTML = '<option disabled>❌ Sin stock disponible en este modelo</option>';
            } else {
                data.forEach(prod => {
                    const option = document.createElement('option');
                    option.value = prod.producto_id;
                    option.dataset.stock = prod.stock.cantidad;
                    option.textContent = `${prod.producto_nombre} (Disponibles: ${prod.stock.cantidad})`;
                    selectProducto.appendChild(option);
                });
                selectProducto.disabled = false;
            }
        });
});

document.getElementById('select-producto').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    stockMaximo = parseInt(selectedOption.dataset.stock);
    document.getElementById('stock-count').textContent = stockMaximo;
    document.getElementById('seccion-detalles').classList.remove('d-none');
    document.getElementById('alert-insuficiente').classList.add('d-none');
});

document.getElementById('input-cantidad').addEventListener('input', function() {
    const valor = parseInt(this.value) || 0;
    const alertInsuficiente = document.getElementById('alert-insuficiente');
    const btn = document.getElementById('btn-submit');
    const stockMsg = document.getElementById('stock-disponible-msg');

    if (valor > stockMaximo) {
        stockMsg.textContent = stockMaximo;
        alertInsuficiente.classList.remove('d-none');
        btn.disabled = true;
        this.classList.add('is-invalid');
    } else {
        alertInsuficiente.classList.add('d-none');
        btn.disabled = (valor <= 0);
        this.classList.remove('is-invalid');
    }
});
</script>
@endsection