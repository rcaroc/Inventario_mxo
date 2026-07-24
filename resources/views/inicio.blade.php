@extends('layouts.app')

@section('content')
<div class="container-fluid">
    {{-- Encabezado del Panel --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark mb-0">Panel de Control</h3>
    </div>

    {{-- Fila de Tarjetas de Estadísticas --}}
    <div class="row">
        {{-- Tarjeta 1: Total Productos --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.75rem; opacity: 0.8;">Total Productos</h6>
                            <h2 class="mb-0 fw-bold">{{ $totalProductos }}</h2>
                        </div>
                        <i class="fas fa-boxes fa-2x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 2: Stock Crítico --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-danger text-white shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.75rem; opacity: 0.8;">Stock Bajo</h6>
                            <h2 class="mb-0 fw-bold">{{ $stockBajo }}</h2>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 3: Entradas --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.75rem; opacity: 0.8;">Entradas Totales</h6>
                            <h2 class="mb-0 fw-bold">{{ $entradasHoy }}</h2>
                        </div>
                        <i class="fas fa-arrow-down fa-2x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 4: Salidas --}}
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1" style="font-size: 0.75rem; opacity: 0.8;">Salidas Totales</h6>
                            <h2 class="mb-0 fw-bold">{{ $salidasHoy }}</h2>
                        </div>
                        <i class="fas fa-arrow-up fa-2x" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SECCIÓN DE PREDICCIÓN CON INTELIGENCIA ARTIFICIAL --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 border-start border-4 border-primary">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-robot me-2"></i>Predicción de Reorden de Inventario (IA)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        {{-- Formulario de Selección --}}
                        <div class="col-md-4 border-end pe-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Seleccionar Producto:</label>
                                <select id="ia_producto_id" class="form-select">
                                    @foreach($productos as $prod)
                                        <option value="{{ $prod->producto_id ?? $prod->id }}">
                                            {{ $prod->producto_nombre ?? $prod->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mes a Predecir:</label>
                                <select id="ia_mes_target" class="form-select">
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8" selected>Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                            <button id="btn-predecir" class="btn btn-primary w-100 fw-bold shadow-sm">
                                <i class="fas fa-magic me-1"></i> Calcular Predicción
                            </button>
                        </div>

                        {{-- Resultados de la Predicción --}}
                        <div class="col-md-8 ps-md-4">
                            <div id="ia-loading" class="text-center py-4" style="display: none;">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2 text-muted fw-bold mb-0">Consultando modelo Random Forest en Render...</p>
                            </div>

                            <div id="ia-resultados" class="row text-center">
                                <div class="col-md-4 mb-2">
                                    <div class="p-3 bg-light rounded border">
                                        <small class="text-muted d-block fw-bold text-uppercase">Demanda Estimada</small>
                                        <h3 id="res-demanda" class="fw-bold text-dark my-1">-</h3>
                                        <small class="text-muted">prendas</small>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="p-3 bg-light rounded border">
                                        <small class="text-muted d-block fw-bold text-uppercase">Stock Seguridad</small>
                                        <h3 id="res-stock" class="fw-bold text-info my-1">-</h3>
                                        <small class="text-muted">prendas</small>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="p-3 bg-light rounded border">
                                        <small class="text-muted d-block fw-bold text-uppercase">Punto Reorden (ROP)</small>
                                        <h3 id="res-rop" class="fw-bold text-warning my-1">-</h3>
                                        <small class="text-muted">prendas</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Fila de Tabla de Movimientos --}}
    <div class="row mt-2">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-history me-2 text-primary"></i>Últimos Movimientos Registrados
                    </h5>
                    <a href="{{ route('movimientos.historial') }}" class="btn btn-outline-primary btn-sm">Ver Todo</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>Usuario Responsable</th>
                                    <th>Fecha y Hora</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimosMovimientos as $mov)
                                <tr>
                                    <td class="fw-bold text-secondary">{{ $mov->producto->producto_nombre ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge rounded-pill {{ strtolower($mov->tipo) == 'entrada' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($mov->tipo) }}
                                        </span>
                                    </td>
                                    <td class="fw-bold {{ strtolower($mov->tipo) == 'entrada' ? 'text-success' : 'text-danger' }}">
                                        {{ strtolower($mov->tipo) == 'entrada' ? '+' : '-' }} {{ $mov->cantidad }}
                                    </td>
                                    <td>
                                        <i class="fas fa-user-circle me-1 text-muted"></i>
                                        {{ $mov->usuario->usuario_usuario ?? 'Sistema' }}
                                    </td>
                                    <td class="text-muted small">
                                        {{ $mov->created_at->format('d/m/Y') }} 
                                        <span class="ms-1 text-secondary opacity-75">{{ $mov->created_at->format('H:i') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="fas fa-folder-open fa-3x mb-3 d-block opacity-25"></i>
                                        No hay movimientos registrados en el sistema.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT JS PARA CONSUMIR LA API DE RENDER --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('btn-predecir');
    
    if (btn) {
        btn.addEventListener('click', async function() {
            const productoId = document.getElementById('ia_producto_id').value;
            const mesTarget = document.getElementById('ia_mes_target').value;
            
            const loading = document.getElementById('ia-loading');
            const resultados = document.getElementById('ia-resultados');
            
            loading.style.display = 'block';
            resultados.style.opacity = '0.3';

            try {
                const response = await fetch('https://mype-jean-ia-service.onrender.com/predecir', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        producto_id: parseInt(productoId),
                        mes_target: parseInt(mesTarget),
                        talla: "S",
                        manga: "larga",
                        precio: 55.0
                    })
                });

                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor IA');
                }

                const data = await response.json();

                document.getElementById('res-demanda').innerText = data.demanda_estimada_prendas;
                document.getElementById('res-stock').innerText = data.stock_seguridad_sugerido;
                document.getElementById('res-rop').innerText = data.punto_reorden_rop;

            } catch (error) {
                alert('Ocurrió un problema al conectar con el microservicio de IA.');
                console.error(error);
            } finally {
                loading.style.display = 'none';
                resultados.style.opacity = '1';
            }
        });
    }
});
</script>
@endsection