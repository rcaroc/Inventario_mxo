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
    // Muestra la vista de Entrada
    public function createEntrada()
    {
        $modelos = Modelo::orderBy('modelo_nombre', 'asc')->get();
        return view('movimientos.entrada', compact('modelos'));
    }

    // Muestra la vista de Salida
    public function createSalida()
    {
        $modelos = Modelo::orderBy('modelo_nombre', 'asc')->get();
        return view('movimientos.salida', compact('modelos'));
    }

    // Procesa el guardado de Entrada
    public function storeEntrada(Request $request)
    {
        $this->registrar($request, 'entrada');
        return redirect()->route('movimientos.entrada')->with('success', 'Entrada registrada con éxito.');
    }

    // Procesa el guardado de Salida
    public function storeSalida(Request $request)
    {
        // Validación lógica: No sacar más de lo que existe
        $producto = Producto::findOrFail($request->producto_id);
        if ($producto->producto_stock < $request->cantidad) {
            return redirect()->back()->with('error', 'Stock insuficiente. Disponible: ' . $producto->producto_stock);
        }

        $this->registrar($request, 'salida');
        return redirect()->route('movimientos.salida')->with('success', 'Salida registrada con éxito.');
    }

    // Lógica común para ambos tipos
    private function registrar(Request $request, $tipo)
    {
        $request->validate([
            'producto_id' => 'required|exists:producto,producto_id',
            'cantidad'    => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $tipo) {
            Movimiento::create([
                'producto_id' => $request->producto_id,
                'usuario_id'  => Auth::id() ?? 1,
                'tipo'        => $tipo,
                'cantidad'    => $request->cantidad,
                'descripcion' => $request->descripcion ?? ucfirst($tipo) . " manual de inventario",
            ]);

            $producto = Producto::findOrFail($request->producto_id);
            if ($tipo == 'entrada') {
                $producto->increment('producto_stock', $request->cantidad);
            } else {
                $producto->decrement('producto_stock', $request->cantidad);
            }
        });
    }

    public function getProductosPorModelo($modelo_id)
    {
        return response()->json(Producto::where('modelo_id', $modelo_id)->get());
    }

    public function historial()
    {
        $movimientos = Movimiento::with(['producto', 'usuario'])->latest()->get();
        return view('movimientos.historial', compact('movimientos'));
    }
}