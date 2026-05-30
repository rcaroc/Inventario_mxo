<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modelo;   // Ya lo tenías
use App\Models\Producto; // <--- ESTO ES LO QUE FALTA
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Reporte de Stock por Modelo
     */
    public function stockModelo()
    {
        // 1. Obtenemos los modelos y contamos sus productos usando la relación hasMany
        $reporte = Modelo::withCount('productos')
            ->get()
            ->map(function ($modelo) {
                // 2. Sumamos el stock de la tabla 'stock' uniendo con 'producto'
                $modelo->stock_total = DB::table('stock')
                    ->join('producto', 'stock.producto_id', '=', 'producto.producto_id')
                    ->where('producto.modelo_id', $modelo->modelo_id)
                    ->sum('stock.cantidad'); // Especificamos tabla.columna por seguridad
                
                return $modelo;
            });

        // 3. Calculamos el total general de todas las filas
        $totalGeneral = $reporte->sum('stock_total');

        // 4. IMPORTANTE: Apuntamos al nombre de tu archivo 'stock_modelo'
        return view('reportes.stock_modelo', compact('reporte', 'totalGeneral'));
    }

    public function stockTalla()
    {
        // Traemos todos los productos con su relación de modelo y stock
        $reporte = Producto::with(['modelo', 'stock'])->get();

        // Traemos la lista de modelos para el select del filtro
        $modelos = Modelo::orderBy('modelo_nombre', 'asc')->get();

        return view('reportes.stock_color_talla', compact('reporte', 'modelos'));
    }
}