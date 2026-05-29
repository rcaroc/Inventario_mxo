<?php

namespace App\Http\Controllers;

use App\Models\Modelo; // Tu nombre exacto de archivo
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('buscar');
        
        // Buscamos por nombre o ubicación si hay algo escrito en el buscador
        $modelos = Modelo::when($query, function ($q) use ($query) {
            return $q->where('modelo_nombre', 'LIKE', "%$query%")
                     ->orWhere('modelo_ubicacion', 'LIKE', "%$query%");
        })->get();

        return view('modelos.index', compact('modelos'));
    }

    public function destroy($id)
    {
        $modelo = Modelo::findOrFail($id);
        $modelo->delete();

        // Enviamos la señal para el cuadro azul
        return redirect()->route('modelos.index')->with('eliminar', 'ok');
    }
}