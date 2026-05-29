@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 text-center mt-5">
        <div class="card shadow-sm p-5">
            <h1 class="display-4">🚀 Sistema de Inventario MXO</h1>
            <p class="lead text-muted">Gestión de Catálogo, Productos y Movimientos</p>
            <hr class="my-4">
            <p>Bienvenido al panel de administración. Utiliza el menú superior para navegar.</p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <a href="{{ route('modelos.index') }}" class="btn btn-primary btn-lg px-4">Ver Catálogo</a>
                <button class="btn btn-outline-secondary btn-lg px-4">Manual de Usuario</button>
            </div>
        </div>
    </div>
</div>
@endsection