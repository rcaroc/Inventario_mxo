<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modelo;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Reporte de Stock por Modelo
     */
    public function stockModelo()
    {
        // Traemos modelos, contamos sus variantes y sumamos el stock total
        $reporte = Modelo::withCount('productos')
            ->get()
            ->map(function ($modelo) {
                $modelo->stock_total = DB::table('stock')
                    ->join('producto', 'stock.producto_id', '=', 'producto.producto_id')
                    ->where('producto.modelo_id', $modelo->modelo_id)
                    ->sum('cantidad');
                return $modelo;
            });

        $totalGeneral = $reporte->sum('stock_total');

        return view('reportes.modelo', compact('reporte', 'totalGeneral'));
    }

    /**
     * Reporte de Stock por Talla y Color (Estructura base)
     */
    public function stockTalla()
    {
        // Por ahora lo dejamos simple para que no de error la ruta
        return view('reportes.talla');
    }
}