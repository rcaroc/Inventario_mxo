@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0">
            <div class="card-body p-5">
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-tachometer-alt fa-3x text-dark me-3"></i>
                    <h1 class="h2 mb-0">Dashboard</h1>
                </div>
                
                <div class="alert alert-info border-0 shadow-sm" style="border-left: 5px solid #0d6efd !important;">
                    <p class="mb-1"><i class="fas fa-user-circle"></i> <strong>Bienvenido:</strong> Administrador</p>
                    <p class="mb-0"><i class="fas fa-tag"></i> <strong>Rol:</strong> <span class="badge bg-danger">Administrador</span></p>
                </div>

                <div class="mt-4">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-danger me-2">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </button>
                    </form>
                    <a href="{{ route('home') }}" class="btn btn-light border">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <h2 class="display-4 fw-bold">Sistema de Inventario</h2>
            <img src="https://em-content.zobj.net/source/microsoft-teams/337/rocket_1f680.png" alt="Rocket" style="width: 80px;">
        </div>
    </div>
</div>
@endsection