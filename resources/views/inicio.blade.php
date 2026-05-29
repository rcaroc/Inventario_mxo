@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <i class="fas fa-tachometer-alt fa-2x me-3"></i>
                        <h2 class="h4 mb-0">Dashboard</h2>
                    </div>

                    <div class="alert alert-info border-0 shadow-sm d-flex align-items-start" style="background-color: #e7f3ff; border-left: 4px solid #0d6efd !important;">
                        <div class="ms-2">
                            <div class="mb-2">
                                <i class="fas fa-user text-primary"></i> 
                                <strong class="ms-1">Bienvenido:</strong> 
                                <span class="text-primary">Administrador</span>
                            </div>
                            <div>
                                <i class="fas fa-tag text-primary"></i> 
                                <strong class="ms-1">Rol:</strong> 
                                <span class="badge bg-danger ms-1" style="font-size: 0.9em; padding: 0.5em 1em;">
                                    <i class="fas fa-shield-alt"></i> Administrador
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger px-4 py-2 me-2">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                        
                        <a href="{{ route('home') }}" class="btn btn-light border px-4 py-2">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <h1 class="display-3 fw-bold text-dark" style="letter-spacing: -1px;">
                    Sistema de Inventario
                    <img src="https://em-content.zobj.net/source/microsoft-teams/337/rocket_1f680.png" alt="Rocket" style="width: 60px; vertical-align: middle;" class="ms-2">
                </h1>
            </div>
        </div>
    </div>
</div>
@endsection