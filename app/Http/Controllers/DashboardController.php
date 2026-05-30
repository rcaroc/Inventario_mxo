<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Movimiento; // Asegúrate de que este modelo exista
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total de productos registrados
        $totalProductos = Producto::count();

        // 2. Stock bajo (Ajusta 'producto_stock' al nombre real de tu columna)
        // Si no tienes columna de stock en Producto, esto dará error hasta que lo ajustemos
        $stockBajo = Producto::where('producto_stock', '<', 5)->count();

        // 3. Movimientos de hoy
        $hoy = Carbon::today();
        $entradasHoy = Movimiento::where('movimiento_tipo', 'Entrada')
                                 ->whereDate('created_at', $hoy)
                                 ->count();
                                 
        $salidasHoy = Movimiento::where('movimiento_tipo', 'Salida')
                                ->whereDate('created_at', $hoy)
                                ->count();

        // 4. Últimos 5 movimientos (Relacionados con producto y usuario)
        $ultimosMovimientos = Movimiento::latest()->take(5)->get();

        return view('inicio', compact(
            'totalProductos', 
            'stockBajo', 
            'entradasHoy', 
            'salidasHoy', 
            'ultimosMovimientos'
        ));
    }
}