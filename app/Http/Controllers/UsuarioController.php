<?php

namespace App\Http\Controllers;

use App\Models\Usuario; // Importante: Importamos el Modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // Muestra la lista de usuarios
    public function index()
    {
        $usuarios = Usuario::all(); // Usamos el Modelo para traer todo
        return view('usuarios.index', compact('usuarios'));
    }

    // Muestra el formulario de creación
    public function create()
    {
        return view('usuarios.create');
    }

    // Guarda el nuevo usuario
    public function store(Request $request)
    {
        // Creamos el registro usando el Modelo
        Usuario::create([
            'usuario_nombre'   => $request->usuario_nombre,
            'usuario_apellido' => $request->usuario_apellido,
            'usuario_usuario'  => $request->usuario_usuario,
            'usuario_clave'    => Hash::make($request->usuario_clave), // Encriptamos la clave
            'rol'              => $request->rol,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado!');
    }
}