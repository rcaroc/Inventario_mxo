<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Stock;
use App\Models\Movimiento;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total de productos registrados
        $totalProductos = Producto::count();

        // 2. Conteo de Stock Bajo (menos de 5 unidades)
        $stockBajo = Stock::where('cantidad', '<', 5)->count();

        // 3. Movimientos del día (usando try-catch para evitar caídas si la tabla está vacía)
        try {
            $hoy = Carbon::today();
            
            // Contar entradas y salidas de hoy
            $entradasHoy = Movimiento::where('movimiento_tipo', 'Entrada')
                                     ->whereDate('created_at', $hoy)
                                     ->count();
                                     
            $salidasHoy = Movimiento::where('movimiento_tipo', 'Salida')
                                    ->whereDate('created_at', $hoy)
                                    ->count();

            // Obtener los últimos 5 movimientos con los datos del producto
            $ultimosMovimientos = Movimiento::with('producto')
                                            ->latest()
                                            ->take(5)
                                            ->get();
        } catch (\Exception $e) {
            // Si algo falla con movimientos, devolvemos valores por defecto
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