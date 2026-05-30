<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MXO - Sistema de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    {{-- CSS DE DATATABLES Y BOTONES --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @yield('css')

    <style>
        body { background-color: #f4f6f9; }
        .navbar-dark { background-color: #1a1d20 !important; }
        .dropdown-menu { border: none; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15); }

        /* Estilos de botones personalizados */
        .btn-editar-custom { background-color: #5c6bc0 !important; color: white !important; padding: 7px 18px; border-radius: 4px; text-decoration: none; font-size: 14px; border: none; font-weight: 500; display: inline-block; transition: background 0.3s; }
        .btn-eliminar-custom { background-color: #ef5350 !important; color: white !important; padding: 7px 18px; border-radius: 4px; border: none; font-size: 14px; font-weight: 500; display: inline-block; transition: background 0.3s; }
        .btn-editar-custom:hover { background-color: #3f51b5 !important; }
        .btn-eliminar-custom:hover { background-color: #e53935 !important; }
        .btn-guardar-custom { background-color: #3498db !important; color: white !important; border-radius: 25px; padding: 10px 40px; border: none; font-weight: 500; }

        /* Badges de Roles */
        .badge-admin { background-color: #ef5350 !important; color: white !important; padding: 5px 12px; border-radius: 4px; font-size: 0.85rem; font-weight: 500; }
        .badge-ventas { background-color: #48c78e !important; color: white !important; padding: 5px 12px; border-radius: 4px; font-size: 0.85rem; font-weight: 500; }
        .badge-inventario { background-color: #ffd54f !important; color: #5d4037 !important; padding: 5px 12px; border-radius: 4px; font-size: 0.85rem; font-weight: 500; }

        /* Estilos específicos para botones de exportación que creará DataTables */
        .dt-buttons { margin-bottom: 15px; }
        .btn-export-pdf { background-color: #5dade2 !important; color: white !important; border: none !important; }
        .btn-export-excel { background-color: #48c78e !important; color: white !important; border: none !important; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">MXO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Inicio</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Usuario</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('usuarios.index') }}">Lista de Usuarios</a></li>
                            <li><a class="dropdown-item" href="{{ route('usuarios.create') }}">Crear Usuario</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Catálogo</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('modelos.index') }}">Lista de Modelos</a></li>
                            <li><a class="dropdown-item" href="{{ route('modelos.create') }}">Nuevo Modelo</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('productos.index') }}">Lista de Productos</a></li>
                            <li><a class="dropdown-item" href="{{ route('productos.create') }}">Nuevo Producto</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Movimiento</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('movimientos.entrada') }}">Registro Entrada</a></li>
                            <li><a class="dropdown-item" href="{{ route('movimientos.salida') }}">Registro Salida</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('movimientos.historial') }}">Historial</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Reporte</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('reportes.modelo') }}">Stock por modelo</a></li>
                            <li><a class="dropdown-item" href="{{ route('reportes.talla') }}">Stock por talla y color</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex align-items-center text-white">
                    <span class="badge bg-primary me-2"><i class="fas fa-user"></i> Administrador</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-light">Salir</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        @yield('content')
    </div>

    {{-- SCRIPTS BASE (ORDEN CRÍTICO) --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- SCRIPTS DE DATATABLES Y EXPORTACIÓN --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    @yield('js')
</body>
</html>