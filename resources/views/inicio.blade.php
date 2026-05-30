@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Tarjeta 1: Total Productos --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Productos</h6>
                            <h2 class="mb-0">125</h2> {{-- Aquí irá un count() de tu BD --}}
                        </div>
                        <i class="fas fa-boxes fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 2: Stock Crítico --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-danger text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Stock Bajo</h6>
                            <h2 class="mb-0">8</h2> {{-- Productos con stock < 5 --}}
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 3: Entradas Hoy --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Entradas Hoy</h6>
                            <h2 class="mb-0">15</h2>
                        </div>
                        <i class="fas fa-arrow-down fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 4: Salidas Hoy --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Salidas Hoy</h6>
                            <h2 class="mb-0">4</h2>
                        </div>
                        <i class="fas fa-arrow-up fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        {{-- Actividad Reciente --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">
                    <i class="fas fa-history me-2"></i> Últimos Movimientos
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Tipo</th>
                                <th>Cant.</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Aquí harías un @foreach de tus movimientos --}}
                            <tr>
                                <td>Polo Oversize M</td>
                                <td><span class="badge bg-success">Entrada</span></td>
                                <td>+20</td>
                                <td>Rosabel Caro</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Perfil rápido --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-3">
                <div class="card-body">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->usuario_nombre }}+{{ Auth::user()->usuario_apellido }}&background=0D8ABC&color=fff" class="rounded-circle mb-3" width="80">
                    <h5>{{ Auth::user()->usuario_nombre }}</h5>
                    <p class="text-muted">{{ ucfirst(Auth::user()->rol) }}</p>
                    <hr>
                    <div class="d-grid">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-primary btn-sm">Ver mi perfil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection