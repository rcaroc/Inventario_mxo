<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Muestra la lista de productos registrados.
     */
    public function index()
    {
        // Cargamos los productos junto con su relación 'modelo' 
        // para evitar errores al mostrar el nombre del modelo.
        $productos = Producto::with('modelo')->get();

        return view('productos.index', compact('productos'));
    }

    /**
     * Elimina un producto específico (variante de modelo+talla+color).
     */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('eliminar', 'ok');
    }

    // Aquí puedes ir agregando create(), store(), edit(), etc.

    public function create() {
    $modelos = \App\Models\Modelo::all();
    return view('productos.create', compact('modelos'));
}

public function store(Request $request) {
    $modelo_id = $request->modelo_id;
    
    // Convertir strings (S, M, L) en arrays limpiando espacios
    $tallas = array_filter(array_map('trim', explode(',', $request->tallas)));
    $colores = array_filter(array_map('trim', explode(',', $request->colores)));

    foreach ($colores as $color) {
        foreach ($tallas as $talla) {
            \App\Models\Producto::create([
                'modelo_id' => $modelo_id,
                'talla' => strtoupper($talla),
                'color' => strtolower($color),
                'stock' => 0 // Por defecto en 0 según tu lógica
            ]);
        }
    }

    return redirect()->route('productos.index')->with('success', 'Productos creados con éxito');
}
}