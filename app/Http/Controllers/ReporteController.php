<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modelo;   
use App\Models\Producto; 
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
    // Datos para la tabla
    $reporte = Producto::with(['modelo', 'stock'])->get();

    // Datos para los filtros (Combobox)
    $modelos = Modelo::orderBy('modelo_nombre', 'asc')->get();
    
    // Obtenemos colores y tallas únicos que existan en la BD
    $colores = Producto::whereNotNull('producto_color')
                        ->distinct()
                        ->pluck('producto_color')
                        ->sort();

    $tallas = Producto::whereNotNull('producto_talla')
                       ->distinct()
                       ->pluck('producto_talla')
                       ->sort();

    return view('reportes.stock_color_talla', compact('reporte', 'modelos', 'colores', 'tallas'));
}
}