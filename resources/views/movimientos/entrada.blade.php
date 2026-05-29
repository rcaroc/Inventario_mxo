@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Movimientos</h1>
        <p class="text-muted">Registrar entrada</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('movimientos.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            {{-- Selector de Modelo --}}
            <div class="col-md-5">
                <label class="form-label fw-bold">Modelo</label>
                <select id="select-modelo" class="form-select border-1 py-2">
                    <option value="" selected disabled>Seleccione un modelo...</option>
                    @foreach($modelos as $m)
                        <option value="{{ $m->modelo_id }}">{{ $m->modelo_nombre }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Selector de Producto (Variante) --}}
            <div class="col-md-7">
                <label class="form-label fw-bold">Producto (variante)</label>
                <select name="producto_id" id="select-producto" class="form-select border-1 py-2" disabled required>
                    <option value="" selected disabled>Seleccione un producto...</option>
                </select>
                <small class="text-muted">Un producto representa una variante (Color/Talla) dentro del modelo seleccionado.</small>
            </div>
        </div>

        {{-- Cantidad y Botón --}}
        <div class="row mt-4 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold">Cantidad a ingresar</label>
                <input type="number" name="cantidad" class="form-control py-2" min="1" placeholder="0" required>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary px-5 py-2 w-100" style="background-color: #3498db; border: none; border-radius: 30px;">
                    Registrar entrada
                </button>
            </div>
        </div>

        <div id="info-box" class="mt-4 p-4 text-center" style="background-color: #f8f9fa; border-radius: 8px; color: #6c757d; border: 1px dashed #dee2e6;">
            Seleccione un <strong>modelo</strong> y luego un <strong>producto</strong> para registrar la entrada.
        </div>
    </form>
</div>

<script>
document.getElementById('select-modelo').addEventListener('change', function() {
    const modeloId = this.value;
    const selectProducto = document.getElementById('select-producto');
    const infoBox = document.getElementById('info-box');
    
    selectProducto.disabled = true;
    selectProducto.innerHTML = '<option>Cargando...</option>';

    fetch(`/api/productos-por-modelo/${modeloId}`)
        .then(response => response.json())
        .then(data => {
            selectProducto.innerHTML = '<option value="" selected disabled>Seleccione un producto...</option>';
            data.forEach(prod => {
                const option = document.createElement('option');
                option.value = prod.producto_id;
                // Usamos los nombres de tu migración anterior: producto_talla y producto_color
                option.textContent = `${prod.producto_talla} / ${prod.producto_color}`;
                selectProducto.appendChild(option);
            });
            selectProducto.disabled = false;
            infoBox.classList.add('d-none');
        });
});
</script>
@endsection