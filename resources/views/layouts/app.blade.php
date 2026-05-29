<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario MXO - UCV</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: 800; letter-spacing: 1px; }
        .nav-link { font-size: 0.95rem; }
        .main-container { margin-top: 30px; margin-bottom: 50px; }
        /* Estilo para los botones de la derecha como en tu prototipo */
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">MXO</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">Inicio</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#">Usuario</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="catalogDropdown" role="button" data-bs-toggle="dropdown">
                            Catálogo
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('modelos.index') }}">Lista de Modelos</a></li>
                            <li><a class="dropdown-item" href="{{ route('modelos.create') }}">Nuevo Modelo</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Lista de Productos</a></li>
                            <li><a class="dropdown-item" href="#">Nuevo Producto</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Movimiento</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Reporte</a>
                    </li>
                </ul>

                <div class="user-info">
                    <span class="badge bg-secondary">Administrador</span>
                    <span class="text-white-50 small">admin@mxo.com</span>
                    <a href="#" class="btn btn-outline-danger btn-sm">Salir</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container main-container">
        @yield('content')
    </div>

    <footer class="text-center py-4 text-muted border-top bg-white mt-auto">
        <small>&copy; 2026 Sistema de Inventario MXO - Evidencia Académica UCV</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>