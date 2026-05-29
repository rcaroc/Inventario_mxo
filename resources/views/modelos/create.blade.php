@extends('layouts.app')

@section('content')
<div class="container mt-4">
    
    {{-- Título y Subtítulo --}}
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">Catálogo</h1>
        <p class="text-muted">Nuevo modelo</p>
    </div>

    {{-- MENSAJE DE ÉXITO (Estilo exacto a la captura) --}}
    @if(session('registrado') == 'ok')
    <div class="alert alert-primary border-0 shadow-sm mb-4" style="background-color: #f0f7ff; border-radius: 8px; padding: 20px; border-left: 5px solid #0056b3 !important;">
        <h5 class="fw-bold mb-1" style="color: #0056b3; letter-spacing: -0.5px;">¡MODELO REGISTRADO!</h5>
        <p class="mb-0" style="color: #0056b3; font-size: 0.95rem;">El modelo se registró con éxito.</p>
    </div>
    @endif

    {{-- FORMULARIO --}}
    <div class="mt-5">
        <form action="{{ route('modelos.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                {{-- Input Nombre del Modelo --}}
                <div class="col-md-6">
                    <label class="form-label text-dark small fw-medium" style="color: #555;">Nombre del modelo</label>
                    <input type="text" name="modelo_nombre" class="form-control py-2 shadow-sm" 
                           placeholder="Escribir modelo" required 
                           style="border-radius: 6px; border: 1px solid #dee2e6;">
                    @error('modelo_nombre')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Input Ubicación --}}
                <div class="col-md-6">
                    <label class="form-label text-dark small fw-medium" style="color: #555;">Ubicación (opcional)</label>
                    <input type="text" name="modelo_ubicacion" class="form-control py-2 shadow-sm" 
                           placeholder="Ej: Anaquel 01" 
                           style="border-radius: 6px; border: 1px solid #dee2e6;">
                    @error('modelo_ubicacion')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- BOTÓN GUARDAR (Estilo Cápsula) --}}
            <div class="text-center" style="margin-top: 3rem;">
                <button type="submit" class="btn btn-primary px-5 shadow" 
                        style="background-color: #3498db; border: none; border-radius: 25px; padding-top: 10px; padding-bottom: 10px; font-weight: 500; min-width: 180px;">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    /* Efecto suave al seleccionar inputs */
    .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.15);
    }

    /* Placeholder en gris claro */
    ::placeholder {
        color: #adb5bd !important;
        font-size: 0.95rem;
    }
</style>
@endsection