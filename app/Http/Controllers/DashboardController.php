<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Stock;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Conteo total de productos y productos con stock crítico (< 5)
        $totalProductos = Producto::count();
        $stockBajo = Stock::where('cantidad', '<', 5)->count();

        // 2. Traer todos los productos para el selector de la IA
        $productos = Producto::all();

        try {
            // 3. Total en Soles de Ventas (salidas) en el año 2026
            $ventas2026 = Movimiento::whereYear('created_at', 2026)
                ->where('tipo', 'salida')
                ->sum('precio_total');

            // 4. Total en Soles de Ventas (salidas) en el año 2025 para comparar
            $ventas2025 = Movimiento::whereYear('created_at', 2025)
                ->where('tipo', 'salida')
                ->sum('precio_total');

            // 5. Cálculo del porcentaje de variación (+ / -)
            $crecimientoAumento = $ventas2025 > 0 
                ? (($ventas2026 - $ventas2025) / $ventas2025) * 100 
                : 0;

            // 6. Prenda más vendida (Top Seller) del año 2026
            $topProducto = Movimiento::select('producto_id', DB::raw('SUM(cantidad) as total_vendido'))
                ->whereYear('created_at', 2026)
                ->where('tipo', 'salida')
                ->groupBy('producto_id')
                ->orderBy('total_vendido', 'desc')
                ->with('producto')
                ->first();

            $nombreTopProducto = $topProducto->producto->producto_nombre ?? 'Sin ventas';

            // 7. Últimos 5 movimientos con relaciones
            $ultimosMovimientos = Movimiento::with(['producto', 'usuario'])
                ->latest('created_at')
                ->take(5)
                ->get();

        } catch (\Exception $e) {
            \Log::error("Error Dashboard: " . $e->getMessage());
            $ventas2026 = 0;
            $ventas2025 = 0;
            $crecimientoAumento = 0;
            $nombreTopProducto = 'N/A';
            $ultimosMovimientos = collect();
        }

        return view('inicio', compact(
            'totalProductos', 
            'stockBajo', 
            'ventas2026',
            'crecimientoAumento',
            'nombreTopProducto',
            'ultimosMovimientos',
            'productos'
        ));
    }
}