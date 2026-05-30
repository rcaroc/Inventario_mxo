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

        try {
            // 2. Traer conteos de movimientos (Total histórico para asegurar que no salga 0)
            // Agrupamos por el campo 'tipo' que tienes en tu modelo Movimiento
            $movimientosStats = Movimiento::select('tipo', DB::raw('count(*) as total'))
                ->groupBy('tipo')
                ->get()
                ->pluck('total', 'tipo');

            // Convertimos a minúsculas para evitar errores de escritura (Entrada vs entrada)
            $entradasHoy = $movimientosStats->get('Entrada') ?? $movimientosStats->get('entrada') ?? 0;
            $salidasHoy  = $movimientosStats->get('Salida') ?? $movimientosStats->get('salida') ?? 0;

            // 3. Últimos 5 movimientos con relaciones cargadas para velocidad (Eager Loading)
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

        return view('inicio', compact(
            'totalProductos', 
            'stockBajo', 
            'entradasHoy', 
            'salidasHoy', 
            'ultimosMovimientos'
        ));
    }
}