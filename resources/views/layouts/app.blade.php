<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MXO - Sistema de Inventario</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-dark {
            background-color: #1a1d20 !important;
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .nav-link {
            font-weight: 500;
        }
        .badge-admin {
            background-color: #0d6efd;
            padding: 0.5em 1em;
        }
        .badge-rol {
            background-color: #dc3545;
            padding: 0.5em 1em;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <span class="text-white">MXO</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navUsuario" role="button" data-bs-toggle="dropdown">
                            Usuario
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('usuarios.index') }}">Lista de Usuarios</a></li>
                            <li><a class="dropdown-item" href="{{ route('usuarios.create') }}">Crear Usuario</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navCatalogo" role="button" data-bs-toggle="dropdown">
                            Catálogo
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('modelos.index') }}">Lista de Modelos</a></li>
                            <li><a class="dropdown-item" href="{{ route('modelos.create') }}">Nuevo Modelo</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('productos.index') }}">Lista de Productos</a></li>
                            <li><a class="dropdown-item" href="{{ route('productos.create') }}">Nuevo Producto</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navMovimiento" role="button" data-bs-toggle="dropdown">
                            Movimiento
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('movimientos.entrada') }}">Registro Entrada</a></li>
                            <li><a class="dropdown-item" href="{{ route('movimientos.salida') }}">Registro Salida</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('movimientos.historial') }}">Historial</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navReporte" role="button" data-bs-toggle="dropdown">
                            Reporte
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('reportes.modelo') }}">Stock por modelo</a></li>
                            <li><a class="dropdown-item" href="{{ route('reportes.talla') }}">Stock por talla y color</a></li>
                        </ul>
                    </li>
                </ul>