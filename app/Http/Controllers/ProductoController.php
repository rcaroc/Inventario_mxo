<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Modelo;
use App\Models\Stock; // Importante: Importar el modelo Stock
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Para usar transacciones

class ProductoController extends Controller
{
    /**
     * Lista de productos
     */
    public function index()
    {
        // Cargamos el modelo y el stock para mostrarlos en la lista
        $productos = Producto::with(['modelo', 'stock'])->get();
        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario de creación
     */
    public function create()
    {
        $modelos = Modelo::all();
        return view('productos.create', compact('modelos'));
    }

    /**
     * Guarda las combinaciones masivas y crea su stock inicial
     */
    public function store(Request $request)
    {
        // 1. Obtener el nombre del modelo
        $modelo = Modelo::findOrFail($request->modelo_id);

        // 2. Procesar tallas y colores
        $tallas = array_filter(array_map('trim', explode(',', str_replace("\n", ",", $request->tallas))));
        $colores = array_filter(array_map('trim', explode(',', str_replace("\n", ",", $request->colores))));

        // Usamos una transacción para que si algo falla, no se creen productos a medias
        DB::transaction(function () use ($tallas, $colores, $request, $modelo) {
            foreach ($colores as $color) {
                foreach ($tallas as $talla) {
                    // 3. Crear el producto
                    $producto = Producto::create([
                        'modelo_id'          => $request->modelo_id,
                        'usuario_id'         => auth()->id() ?? 1,
                        'producto_nombre'    => $modelo->modelo_nombre . " - " . strtoupper($color) . " - " . strtoupper($talla),
                        'producto_talla'     => strtoupper($talla),
                        'producto_color'     => strtoupper($color),
                        'producto_proveedor' => null,
                    ]);

                    // 4. Crear el registro de stock inicial vinculado al producto
                    Stock::create([
                        'producto_id' => $producto->producto_id,
                        'cantidad'    => 0,
                    ]);
                }
            }
        });

        return redirect()->route('productos.index')->with('success', '¡Combinaciones y registros de stock creados!');
    }

    /**
     * Elimina un producto
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        
        // Gracias a onDelete('cascade') en tu migración, 
        // al eliminar el producto se borrará automáticamente su stock.
        $producto->delete();

        return redirect()->route('productos.index')->with('eliminar', 'ok');
    }
}