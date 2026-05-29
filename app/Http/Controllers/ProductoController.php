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
        $request->validate([
            'modelo_id' => 'required',
            'tallas' => 'required',
            'colores' => 'required',
        ]);

        // Procesar tallas y colores (separados por coma o línea)
        $tallas = array_filter(array_map('trim', explode(',', str_replace("\n", ",", $request->tallas))));
        $colores = array_filter(array_map('trim', explode(',', str_replace("\n", ",", $request->colores))));

        foreach ($colores as $color) {
            foreach ($tallas as $talla) {
                Producto::create([
                    'modelo_id' => $request->modelo_id,
                    'talla' => strtoupper($talla),
                    'color' => strtolower($color),
                    'stock' => 0
                ]);
            }
        }

        return redirect()->route('productos.index')->with('success', '¡Productos creados exitosamente!');
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