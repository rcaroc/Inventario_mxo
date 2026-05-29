@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h1 class="fw-bold text-dark mb-0">Catálogo</h1>
        <p class="text-muted">Editar modelo: <strong>{{ $modelo->modelo_nombre }}</strong></p>
    </div>

    <form action="{{ route('modelos.update', $modelo->modelo_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label text-dark small fw-medium">Nombre del modelo</label>
                <input type="text" name="modelo_nombre" class="form-control py-2 shadow-sm" 
                       value="{{ $modelo->modelo_nombre }}" required style="border-radius: 6px;">
            </div>

            <div class="col-md-6">
                <label class="form-label text-dark small fw-medium">Ubicación (opcional)</label>
                <input type="text" name="modelo_ubicacion" class="form-control py-2 shadow-sm" 
                       value="{{ $modelo->modelo_ubicacion }}" style="border-radius: 6px;">
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('modelos.index') }}" class="btn btn-light border px-4 me-2" style="border-radius: 25px;">Cancelar</a>
            <button type="submit" class="btn btn-primary px-5" style="background-color: #3498db; border: none; border-radius: 25px; font-weight: 500;">
                Actualizar Cambios
            </button>
        </div>
    </form>
</div>
@endsection