@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Productos</h1>
        <p class="text-muted">Nuevo producto</p>
    </div>

    <form action="{{ route('productos.store') }}" method="POST" id="formProductos">
        @csrf
        <div class="card shadow-sm border-0 p-4" style="border-radius: 12px;">
            <div class="row g-3">
                {{-- Categoría / Modelo --}}
                <div class="col-12">
                    <label class="form-label fw-bold">Categoría (Modelo) <span class="text-danger">*</span></label>
                    <select name="modelo_id" id="selectModelo" class="form-select border-1 py-2" required>
                        <option value="" selected disabled>Selecciona un modelo...</option>
                        @foreach($modelos as $m)
                            <option value="{{ $m->modelo_id }}" data-nombre="{{ $m->modelo_nombre }}">{{ $m->modelo_nombre }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tallas --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Talla(s)</label>
                    <textarea name="tallas" id="inputTallas" class="form-control" rows="3" placeholder="Ej: S, M, L, XL o una por línea..."></textarea>
                    <small class="text-muted">Puedes ingresar <strong>varias</strong> separadas por coma o una por línea.</small>
                </div>

                {{-- Colores --}}
                <div class="col-md-6">
                    <label class="form-label fw-bold">Color(es)</label>
                    <textarea name="colores" id="inputColores" class="form-control" rows="3" placeholder="Ej: azul, negro, blanco, rojo o una por línea..."></textarea>
                    <small class="text-muted">Puedes ingresar <strong>varios</strong> separados por coma o una por línea.</small>
                </div>
            </div>

            {{-- PREVISUALIZACIÓN (Similar a tu captura) --}}
            <div id="previsualizacionBox" class="mt-4 d-none">
                <div class="alert alert-info border-0 shadow-sm" style="background-color: #f0f7ff; color: #0056b3;">
                    <h6 class="fw-bold mb-2">Previsualización</h6>
                    <p class="mb-2" id="resumenConteo">0 producto(s) se crearán:</p>
                    <ul class="list-unstyled mb-1" id="listaCombinaciones" style="max-height: 200px; overflow-y: auto;">
                        {{-- Se llena con JS --}}
                    </ul>
                    <small class="d-block mt-2 opacity-75">El nombre se genera automáticamente: <strong>Modelo - Color - Talla</strong></small>
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2" style="border-radius: 30px; background-color: #3498db; border: none;">Guardar</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = ['inputTallas', 'inputColores', 'selectModelo'];
    
    inputs.forEach(id => {
        document.getElementById(id).addEventListener('input', actualizarPrevisualizacion);
    });

    function actualizarPrevisualizacion() {
        const modeloText = document.getElementById('selectModelo').options[document.getElementById('selectModelo').selectedIndex].getAttribute('data-nombre') || 'Modelo';
        const tallasRaw = document.getElementById('inputTallas').value;
        const coloresRaw = document.getElementById('inputColores').value;

        // Limpiar y convertir a arreglos
        const tallas = tallasRaw.split(/[\n,]+/).map(t => t.trim()).filter(t => t !== "");
        const colores = coloresRaw.split(/[\n,]+/).map(c => c.trim()).filter(c => c !== "");

        const lista = document.getElementById('listaCombinaciones');
        const box = document.getElementById('previsualizacionBox');
        const resumen = document.getElementById('resumenConteo');
        
        lista.innerHTML = '';
        
        if (tallas.length > 0 && colores.length > 0) {
            box.classList.remove('d-none');
            let count = 0;

            colores.forEach(color => {
                tallas.forEach(talla => {
                    count++;
                    const li = document.createElement('li');
                    li.className = 'mb-1';
                    li.innerHTML = `📦 ${modeloText} - ${color.toUpperCase()} - ${talla.toUpperCase()}`;
                    lista.appendChild(li);
                });
            });
            resumen.innerHTML = `<strong>${count} producto(s)</strong> se crearán:`;
        } else {
            box.classList.add('d-none');
        }
    }
});
</script>
@endsection