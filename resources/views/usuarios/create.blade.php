@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="mb-5">
        <h1 class="fw-bold text-dark mb-1" style="font-size: 2.5rem; letter-spacing: -1px;">Usuarios</h1>
        <p class="text-muted fs-5">Nuevo usuario</p>
    </div>

    {{-- Alerta superior opcional para ver todos los errores juntos --}}
    @if ($errors->any())
        <div class="alert alert-danger shadow-sm mb-4" style="border-radius: 8px;">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        
        <div class="row g-4">
            {{-- Nombres --}}
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark">Nombres</label>
                <input type="text" name="usuario_nombre" value="{{ old('usuario_nombre') }}" 
                    class="form-control form-control-lg border-2 @error('usuario_nombre') is-invalid @enderror" 
                    placeholder="Ej: Juan" style="border-radius: 8px; background-color: #f8f9fa;">
            </div>

            {{-- Apellidos --}}
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark">Apellidos</label>
                <input type="text" name="usuario_apellido" value="{{ old('usuario_apellido') }}" 
                    class="form-control form-control-lg border-2 @error('usuario_apellido') is-invalid @enderror" 
                    placeholder="Ej: Pérez" style="border-radius: 8px; background-color: #f8f9fa;">
            </div>

            {{-- Usuario --}}
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark">Usuario</label>
                <input type="text" name="usuario_usuario" value="{{ old('usuario_usuario') }}" 
                    class="form-control form-control-lg border-2 @error('usuario_usuario') is-invalid @enderror" 
                    placeholder="Administrador" style="border-radius: 8px; background-color: #f8f9fa;">
            </div>

            {{-- Rol --}}
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark">Rol</label>
                <select name="rol" class="form-select form-select-lg border-2 @error('rol') is-invalid @enderror" style="border-radius: 8px; background-color: #f8f9fa;">
                    <option value="" selected disabled>Seleccione un rol</option>
                    <option value="inventario" {{ old('rol') == 'inventario' ? 'selected' : '' }}>Encargado de Inventario</option>
                    <option value="ventas" {{ old('rol') == 'ventas' ? 'selected' : '' }}>Encargado de Ventas</option>
                </select>
            </div>

            {{-- Clave --}}
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark">Clave</label>
                <input type="password" name="usuario_clave" 
                    class="form-control form-control-lg border-2 @error('usuario_clave') is-invalid @enderror" 
                    placeholder="Mínimo 6 caracteres" style="border-radius: 8px; background-color: #f8f9fa;">
                @error('usuario_clave')
                    <div class="invalid-feedback fw-bold">{{ $message }}</div>
                @enderror
            </div>

            {{-- Repetir clave --}}
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark">Repetir clave</label>
                <input type="password" name="usuario_clave_confirmation" 
                    class="form-control form-control-lg border-2" 
                    placeholder="Repite la contraseña" style="border-radius: 8px; background-color: #f8f9fa;">
                <div class="form-text">Debe coincidir exactamente con la clave de arriba.</div>
            </div>
        </div>

        <div class="mt-5 d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm" style="border-radius: 50px; background-color: #3b82f6; border: none;">
                Guardar
            </button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-link text-decoration-none text-muted fw-bold">
                Cancelar
            </a>
        </div>
    </form>
</div>

<style>
    /* Estilos para que se parezca más a la imagen */
    body {
        background-color: #f3f4f6; /* Fondo gris muy claro */
    }
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1);
    }
    label {
        font-size: 0.95rem;
        margin-bottom: 0.5rem;
    }
    input::placeholder {
        color: #adb5bd;
        font-size: 0.9rem;
    }
</style>
@endsection