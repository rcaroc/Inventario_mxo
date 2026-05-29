<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Modelo;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Lista de productos con su stock cargado
     */
    public function index()
    {
        // Usamos Eager Loading para cargar el stock y evitar el error "Property [cantidad] does not exist"
        $productos = Producto::with(['modelo', 'stock'])->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $modelos = Modelo::all();
        return view('productos.create', compact('modelos'));
    }

    /**
     * Guarda combinaciones masivas y crea sus registros de stock iniciales
     */
    public function store(Request $request)
    {
        $modelo = Modelo::findOrFail($request->modelo_id);

        $tallas = array_filter(array_map('trim', explode(',', str_replace("\n", ",", $request->tallas))));
        $colores = array_filter(array_map('trim', explode(',', str_replace("\n", ",", $request->colores))));

        DB::transaction(function () use ($tallas, $colores, $request, $modelo) {
            foreach ($colores as $color) {
                foreach ($tallas as $talla) {
                    $producto = Producto::create([
                        'modelo_id'          => $request->modelo_id,
                        'usuario_id'         => auth()->id() ?? 1,
                        'producto_nombre'    => $modelo->modelo_nombre . " - " . strtoupper($color) . " - " . strtoupper($talla),
                        'producto_talla'     => strtoupper($talla),
                        'producto_color'     => strtoupper($color),
                        'producto_proveedor' => null,
                    ]);

                    // Crear fila de stock inicial obligatorio
                    Stock::create([
                        'producto_id' => $producto->producto_id,
                        'cantidad'    => 0,
                    ]);
                }
            }
        });

        return redirect()->route('productos.index')->with('success', '¡Productos y registros de stock creados!');
    }

    /**
     * Elimina un producto solo si su stock es 0
     */
    public function destroy($id)
    {
        $producto = Producto::with('stock')->findOrFail($id);

        // Lógica de seguridad en el Servidor
        if ($producto->stock && $producto->stock->cantidad > 0) {
            return redirect()->route('productos.index')
                             ->with('error', 'No se puede eliminar un producto que tiene stock disponible.');
        }

        $producto->delete();

        return redirect()->route('productos.index')->with('eliminar', 'ok');
    }
}