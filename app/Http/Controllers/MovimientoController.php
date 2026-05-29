<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Models\Producto;
use App\Models\Movimiento;
use App\Models\Stock; // Importamos el modelo Stock
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MovimientoController extends Controller
{
    public function createEntrada()
    {
        $modelos = Modelo::orderBy('modelo_nombre', 'asc')->get();
        return view('movimientos.entrada', compact('modelos'));
    }

    public function createSalida()
    {
        $modelos = Modelo::orderBy('modelo_nombre', 'asc')->get();
        return view('movimientos.salida', compact('modelos'));
    }

    public function storeEntrada(Request $request)
    {
        $this->registrar($request, 'entrada');
        return redirect()->route('movimientos.entrada')->with('success', 'Entrada registrada con éxito.');
    }

    public function storeSalida(Request $request)
    {
        // Validación: Buscar el stock en la tabla 'stock'
        $stock = Stock::where('producto_id', $request->producto_id)->first();
        
        if (!$stock || $stock->cantidad < $request->cantidad) {
            return redirect()->back()->with('error', 'Stock insuficiente. Disponible: ' . ($stock->cantidad ?? 0));
        }

        $this->registrar($request, 'salida');
        return redirect()->route('movimientos.salida')->with('success', 'Salida registrada con éxito.');
    }

    private function registrar(Request $request, $tipo)
    {
        $request->validate([
            'producto_id' => 'required|exists:producto,producto_id',
            'cantidad'    => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $tipo) {
            // 1. Crear el movimiento
            Movimiento::create([
                'producto_id' => $request->producto_id,
                'usuario_id'  => Auth::id() ?? 1,
                'tipo'        => $tipo,
                'cantidad'    => $request->cantidad,
                'descripcion' => $request->descripcion ?? ucfirst($tipo) . " manual de inventario",
            ]);

            // 2. ACTUALIZAR EN LA TABLA 'stock' (No en 'producto')
            // Buscamos el registro por producto_id
            $registroStock = Stock::where('producto_id', $request->producto_id)->first();

            if ($tipo == 'entrada') {
                $registroStock->increment('cantidad', $request->cantidad);
            } else {
                $registroStock->decrement('cantidad', $request->cantidad);
            }
        });
    }

    public function getProductosPorModelo($modelo_id)
    {
        // Cargamos el producto con su stock para mostrarlo en el banner azul
        $productos = Producto::with('stock')
            ->where('modelo_id', $modelo_id)
            ->get();

        return response()->json($productos);
    }

    public function historial()
    {
        $movimientos = Movimiento::with(['producto', 'usuario'])->latest()->get();
        return view('movimientos.historial', compact('movimientos'));
    }


}