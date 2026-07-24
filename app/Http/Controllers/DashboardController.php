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
        // 1. Conteos básicos
        $totalProductos = Producto::count();
        $stockBajo = Stock::where('cantidad', '<', 5)->count();

        // 2. Traer todos los productos para que el usuario los elija en el selector de la IA
        $productos = Producto::all();

        try {
            // 3. Traer conteos de movimientos (Total histórico)
            $movimientosStats = Movimiento::select('tipo', DB::raw('count(*) as total'))
                ->groupBy('tipo')
                ->get()
                ->pluck('total', 'tipo');

            // Convertimos a minúsculas para evitar errores de escritura
            $entradasHoy = $movimientosStats->get('Entrada') ?? $movimientosStats->get('entrada') ?? 0;
            $salidasHoy  = $movimientosStats->get('Salida') ?? $movimientosStats->get('salida') ?? 0;

            // 4. Últimos 5 movimientos con relaciones cargadas para velocidad
            $ultimosMovimientos = Movimiento::with(['producto', 'usuario'])
                ->latest('created_at')
                ->take(5)
                ->get();

        } catch (\Exception $e) {
            \Log::error("Error Dashboard: " . $e->getMessage());
            $entradasHoy = 0;
            $salidasHoy = 0;
            $ultimosMovimientos = collect();
        }

        // Retornamos la vista pasando todas las variables, incluyendo $productos
        return view('inicio', compact(
            'totalProductos', 
            'stockBajo', 
            'entradasHoy', 
            'salidasHoy', 
            'ultimosMovimientos',
            'productos'
        ));
    }
}