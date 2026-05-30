@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h2 class="h4 mb-4"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</h2>

                {{-- Lógica para definir el color del badge según el rol --}}
                @php
                    $badgeClass = 'bg-success'; // Color para Ventas (Verde)
                    if(Auth::user()->rol == 'administrador') $badgeClass = 'bg-danger'; // Rojo
                    if(Auth::user()->rol == 'inventario') $badgeClass = 'bg-warning text-dark'; // Amarillo
                @endphp

                <div class="alert alert-info border-0 shadow-sm" style="background-color: #e7f3ff; border-left: 4px solid #0d6efd !important;">
                    {{-- Nombre dinámico --}}
                    <div class="mb-2">
                        <i class="fas fa-user"></i> 
                        <strong>Bienvenido:</strong> {{ Auth::user()->usuario_nombre }} {{ Auth::user()->usuario_apellido }}
                    </div>
                    
                    {{-- Rol dinámico --}}
                    <div>
                        <i class="fas fa-tag"></i> 
                        <strong>Rol:</strong> 
                        <span class="badge {{ $badgeClass }} ms-1">
                            {{ ucfirst(Auth::user()->rol) }}
                        </span>
                    </div>
                </div>

                <div class="mt-4">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger me-2"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
                    </form>
                    <a href="{{ route('home') }}" class="btn btn-light border">Inicio</a>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <h1 class="display-3 fw-bold">Sistema de Inventario <img src="https://em-content.zobj.net/source/microsoft-teams/337/rocket_1f680.png" width="60"></h1>
        </div>
    </div>
</div>
@endsection