<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Models\Producto;
use App\Models\Movimiento;
use App\Models\Stock;
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
        $stock = Stock::where('producto_id', $request->producto_id)->first();
        
        if (!$stock || $stock->cantidad < $request->cantidad) {
            return redirect()->back()->with('error', '¡Atención! El stock cambió mientras realizabas la operación.');
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
            Movimiento::create([
                'producto_id' => $request->producto_id,
                'usuario_id'  => Auth::id() ?? 1,
                'tipo'        => $tipo,
                'cantidad'    => $request->cantidad,
                'descripcion' => $request->descripcion ?? ucfirst($tipo) . " manual de inventario",
            ]);

            $registroStock = Stock::where('producto_id', $request->producto_id)->first();
            if ($tipo == 'entrada') {
                $registroStock->increment('cantidad', $request->cantidad);
            } else {
                $registroStock->decrement('cantidad', $request->cantidad);
            }
        });
    }

    /**
     * API para cargar productos. 
     * Se puede pasar un parámetro ?con_stock=1 para filtrar solo los que tienen cantidad > 0
     */
    public function getProductosPorModelo(Request $request, $modelo_id)
    {
        $query = Producto::with('stock')->where('modelo_id', $modelo_id);

        if ($request->has('con_stock')) {
            $query->whereHas('stock', function($q) {
                $q->where('cantidad', '>', 0);
            });
        }

        return response()->json($query->get());
    }

    public function historial()
    {
        // Usamos eager loading para cargar las relaciones.
        // Añadimos 'latest()' para que el historial muestre lo más nuevo primero por defecto.
        $movimientos = Movimiento::with(['producto.modelo', 'usuario'])
                        ->latest('movimiento_id') 
                        ->get();
        
        return view('movimientos.historial', compact('movimientos'));
    }
}