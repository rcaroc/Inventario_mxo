<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Models\Producto;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MovimientoController extends Controller
{
    /**
     * Muestra el formulario para registrar una entrada (Movimientos -> Registrar entrada)
     */
    public function create()
    {
        // Traemos todos los modelos para el primer selector
        $modelos = Modelo::orderBy('modelo_nombre', 'asc')->get();
        
        return view('movimientos.entrada', compact('modelos'));
    }

    /**
     * Retorna los productos de un modelo específico en formato JSON (Para el JS del select)
     */
    public function getProductosPorModelo($modelo_id)
    {
        $productos = Producto::where('modelo_id', $modelo_id)
            ->select('producto_id', 'producto_nombre', 'producto_talla', 'producto_color')
            ->orderBy('producto_talla', 'asc')
            ->get();

        return response()->json($productos);
    }

    /**
     * Guarda el movimiento de entrada y actualiza el stock del producto
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'producto_id' => 'required|exists:producto,producto_id',
            'cantidad'    => 'required|integer|min:1',
        ]);

        try {
            // Usamos una transacción para asegurar que si falla el stock, no se cree el movimiento (y viceversa)
            DB::transaction(function () use ($request) {
                
                // 1. Crear el registro en la tabla 'movimiento'
                Movimiento::create([
                    'producto_id' => $request->producto_id,
                    'usuario_id'  => Auth::id() ?? 1, // Usuario actual o ID 1 por defecto
                    'tipo'        => 'entrada',
                    'cantidad'    => $request->cantidad,
                    'descripcion' => 'Entrada manual de inventario'
                ]);

                // 2. Incrementar el stock en la tabla 'producto'
                // Nota: Asegúrate de que tu columna en 'producto' se llama 'producto_stock'
                $producto = Producto::findOrFail($request->producto_id);
                $producto->increment('producto_stock', $request->cantidad);
            });

            return redirect()->route('movimientos.create')
                             ->with('success', '¡Entrada registrada y stock actualizado correctamente!');

        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Ocurrió un error al procesar la entrada: ' . $e->getMessage());
        }
    }
}