<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        <i class="fas fa-exchange-alt"></i> Movimiento
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('movimientos.entrada') }}">Registro Entrada</a></li>
        <li><a class="dropdown-item" href="{{ route('movimientos.salida') }}">Registro Salida</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="{{ route('movimientos.historial') }}">Historial</a></li>
    </ul>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
        <i class="fas fa-file-invoice"></i> Reporte
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('reportes.modelo') }}">Stock por modelo</a></li>
        <li><a class="dropdown-item" href="{{ route('reportes.talla') }}">Stock por talla y color</a></li>
    </ul>
</li>