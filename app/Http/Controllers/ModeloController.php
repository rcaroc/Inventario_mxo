<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
        public function index(Request $request)
        {
            // Obtenemos el texto del input 'buscar'
            $buscar = trim($request->get('buscar'));

            if ($buscar) {
                // Usamos ILIKE para que no importe mayúsculas/minúsculas
                $modelos = Modelo::where('modelo_nombre', 'ILIKE', '%' . $buscar . '%')
                                ->orWhere('modelo_ubicacion', 'ILIKE', '%' . $buscar . '%')
                                ->get();
            } else {
                // Si no hay búsqueda, traemos todos
                $modelos = Modelo::all();
            }

            return view('modelos.index', compact('modelos'));
        }

    public function create()
    {
        return view('modelos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'modelo_nombre' => 'required|max:100',
            'modelo_ubicacion' => 'nullable|max:100',
        ]);

        Modelo::create($request->all());
        return redirect()->route('modelos.create')->with('registrado', 'ok');
    }

    public function edit($id)
    {
        $modelo = Modelo::findOrFail($id);
        return view('modelos.edit', compact('modelo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'modelo_nombre' => 'required|max:100',
            'modelo_ubicacion' => 'nullable|max:100',
        ]);

        $modelo = Modelo::findOrFail($id);
        $modelo->update($request->all());

        return redirect()->route('modelos.index')->with('actualizado', 'ok');
    }

    public function destroy($id)
    {
        $modelo = Modelo::findOrFail($id);
        $modelo->delete();
        return redirect()->route('modelos.index')->with('eliminar', 'ok');
    }
}