<?php

namespace App\Http\Controllers;

use App\Models\Modelo; // Tu archivo se llama Modelo.php
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    /**
     * 1. LISTA DE MODELOS (Vista de Catálogo)
     * Incluye la lógica del buscador por nombre o ubicación.
     */
    public function index(Request $request)
    {
        $query = $request->input('buscar');
        
        // Filtra si el usuario escribió algo en el input de búsqueda
        $modelos = Modelo::when($query, function ($q) use ($query) {
            return $q->where('modelo_nombre', 'LIKE', "%$query%")
                     ->orWhere('modelo_ubicacion', 'LIKE', "%$query%");
        })->get();

        return view('modelos.index', compact('modelos'));
    }

    /**
     * 2. MOSTRAR FORMULARIO (Vista Nuevo Modelo)
     */
    public function create()
    {
        return view('modelos.create');
    }

    /**
     * 3. GUARDAR EN BASE DE DATOS
     * Redirige con la señal 'registrado' -> 'ok' para el aviso azul.
     */
    public function store(Request $request)
    {
        // Validamos que el nombre no esté vacío
        $request->validate([
            'modelo_nombre' => 'required|max:100',
            'modelo_ubicacion' => 'nullable|max:100',
        ]);

        // Guardamos en Supabase usando el Modelo
        Modelo::create([
            'modelo_nombre' => $request->modelo_nombre,
            'modelo_ubicacion' => $request->modelo_ubicacion,
        ]);

        // Regresamos a la misma página de creación con el mensaje de éxito
        return redirect()->route('modelos.create')->with('registrado', 'ok');
    }

    /**
     * 4. ELIMINAR MODELO
     * Redirige con la señal 'eliminar' -> 'ok' para el aviso azul en la lista.
     */
    public function destroy($id)
    {
        $modelo = Modelo::findOrFail($id);
        $modelo->delete();

        // Regresamos a la lista de catálogo
        return redirect()->route('modelos.index')->with('eliminar', 'ok');
    }

    /**
     * 5. EDITAR (Opcional por ahora)
     */
    public function edit($id)
    {
        $modelo = Modelo::findOrFail($id);
        return view('modelos.edit', compact('modelo'));
    }

    /**
     * 6. ACTUALIZAR (Opcional por ahora)
     */
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
}