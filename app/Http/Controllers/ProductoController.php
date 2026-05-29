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
}