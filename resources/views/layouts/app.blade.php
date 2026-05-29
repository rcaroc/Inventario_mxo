<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 Sistema de Inventario MXO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-dark { background-color: #212529 !important; }
        .nav-link { color: rgba(255,255,255,.8) !important; }
        .nav-link:hover { color: #fff !important; }
        .active-link { border-bottom: 2px solid #0d6efd; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <span style="color: #fff;">MXO</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home"></i> Inicio</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropUsuario" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i> Usuario
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('usuarios.index') }}"><i class="fas fa-list"></i> Lista de Usuarios</a></li>
                        <li><a class="dropdown-item" href="{{ route('usuarios.create') }}"><i class="fas fa-user-plus"></i> Crear Usuario</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropCatalogo" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-box"></i> Catálogo
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('modelos.index') }}">Lista de Modelos</a></li>
                        <li><a class="dropdown-item" href="{{ route('modelos.create') }}">Nuevo Modelo</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('productos.index') }}">Lista de Productos</a></li>
                        <li><a class="dropdown-item" href="{{ route('productos.create') }}">Nuevo Producto</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('movimientos.index') }}"><i class="fas fa-exchange-alt"></i> Movimiento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('reportes.index') }}"><i class="fas fa-file-alt"></i> Reporte</a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <span class="badge bg-primary me-2 p-2"><i class="fas fa-user-shield"></i> Administrador</span>
                <span class="badge bg-danger p-2"><i class="fas fa-shield-alt"></i> Administrador</span>
                <form action="{{ route('logout') }}" method="POST" class="ms-3">
                    @csrf
                    <button class="btn btn-sm btn-outline-light"><i class="fas fa-sign-out-alt"></i> Salir</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<div class="container">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>