<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Modelo;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Lista de productos
     */
    public function index()
    {
        $productos = Producto::with('modelo')->get();
        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario de creación (Ruta: productos.create)
     */
    public function create()
    {
        $modelos = Modelo::all();
        return view('productos.create', compact('modelos'));
    }

    /**
     * Guarda las combinaciones masivas (Ruta: productos.store)
     */
public function store(Request $request)
{
    // 1. Obtener el nombre del modelo para armar el 'producto_nombre'
    $modelo = \App\Models\Modelo::findOrFail($request->modelo_id);

    // 2. Procesar tallas y colores desde el textarea
    $tallas = array_filter(array_map('trim', explode(',', str_replace("\n", ",", $request->tallas))));
    $colores = array_filter(array_map('trim', explode(',', str_replace("\n", ",", $request->colores))));

    foreach ($colores as $color) {
        foreach ($tallas as $talla) {
            \App\Models\Producto::create([
                'modelo_id'          => $request->modelo_id,
                'usuario_id'         => auth()->id() ?? 1, // Asigna el usuario logueado o el ID 1 por defecto
                'producto_nombre'    => $modelo->modelo_nombre . " - " . strtoupper($color) . " - " . strtoupper($talla),
                'producto_talla'     => strtoupper($talla),
                'producto_color'     => strtoupper($color),
                'producto_proveedor' => null, // Omitimos proveedor como pediste
            ]);
        }
    }

    return redirect()->route('productos.index')->with('success', '¡Combinaciones creadas!');
}

    /**
     * Elimina un producto (Ruta: productos.destroy)
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('eliminar', 'ok');
    }
}