@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="mb-5">
        <h1 class="fw-bold text-dark mb-1" style="font-size: 2.5rem; letter-spacing: -1px;">Usuarios</h1>
        <p class="text-muted fs-5">Editar usuario: <span class="text-primary">{{ $usuario->usuario_usuario }}</span></p>
    </div>

    {{-- Importante: Usamos el método PUT para actualizar --}}
    <form action="{{ route('usuarios.update', $usuario->usuario_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold text-dark">Nombres</label>
                <input type="text" name="usuario_nombre" class="form-control form-control-lg border-2" 
                       value="{{ old('usuario_nombre', $usuario->usuario_nombre) }}" 
                       style="border-radius: 8px; background-color: #f8f9fa;" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold text-dark">Apellidos</label>
                <input type="text" name="usuario_apellido" class="form-control form-control-lg border-2" 
                       value="{{ old('usuario_apellido', $usuario->usuario_apellido) }}" 
                       style="border-radius: 8px; background-color: #f8f9fa;" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold text-dark">Usuario</label>
                <input type="text" name="usuario_usuario" class="form-control form-control-lg border-2" 
                       value="{{ old('usuario_usuario', $usuario->usuario_usuario) }}" 
                       style="border-radius: 8px; background-color: #f8f9fa;" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold text-dark">Rol</label>
                <select name="rol" class="form-select form-select-lg border-2" style="border-radius: 8px; background-color: #f8f9fa;" required>
                    <option value="administrador" {{ $usuario->rol == 'administrador' ? 'selected' : '' }}>Administrador</option>
                    <option value="inventario" {{ $usuario->rol == 'inventario' ? 'selected' : '' }}>Encargado de Inventario</option>
                    <option value="ventas" {{ $usuario->rol == 'ventas' ? 'selected' : '' }}>Encargado de Ventas</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold text-dark">Nueva Clave (Opcional)</label>
                <input type="password" name="usuario_clave" class="form-control form-control-lg border-2" 
                       placeholder="Dejar en blanco para no cambiar" 
                       style="border-radius: 8px; background-color: #f8f9fa;">
                <div class="form-text text-muted small">Solo escribe aquí si deseas cambiar la contraseña actual.</div>
            </div>
        </div>

        <div class="mt-5 d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm" style="border-radius: 50px; background-color: #3b82f6; border: none;">
                Actualizar Datos
            </button>
            <a href="{{ route('usuarios.index') }}" class="btn btn-link text-decoration-none text-muted fw-bold">
                Cancelar
            </a>
        </div>
    </form>
</div>

<style>
    body { background-color: #f3f4f6; }
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.25rem rgba(59, 130, 246, 0.1);
    }
</style>
@endsection