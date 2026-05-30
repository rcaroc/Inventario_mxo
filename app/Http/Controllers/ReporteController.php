<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modelo; // Importante
use Illuminate\Support\Facades\DB; // Importante para el sum

class ReporteController extends Controller
{
    public function reportePorModelo()
    {
        // Obtenemos los modelos con el conteo de productos
        $reporte = Modelo::withCount('productos')
            ->get()
            ->map(function ($modelo) {
                // Sumamos el stock de todos los productos que pertenecen a este modelo
                $modelo->stock_total = DB::table('stock')
                    ->join('producto', 'stock.producto_id', '=', 'producto.producto_id')
                    ->where('producto.modelo_id', $modelo->modelo_id)
                    ->sum('cantidad');
                return $modelo;
            });

        $totalGeneral = $reporte->sum('stock_total');

        return view('reportes.modelo', compact('reporte', 'totalGeneral'));
    }
}