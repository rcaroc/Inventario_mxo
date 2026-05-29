<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    // 1. LISTAR USUARIOS
    public function index()
    {
        $usuarios = Usuario::all(); 
        return view('usuarios.index', compact('usuarios'));
    }

    // 2. MOSTRAR FORMULARIO DE CREACIÓN
    public function create()
    {
        return view('usuarios.create');
    }

    // 3. GUARDAR NUEVO USUARIO
    public function store(Request $request)
    {
        $request->validate([
            'usuario_nombre'   => 'required|max:40',
            'usuario_apellido' => 'required|max:40',
            'usuario_usuario'  => 'required|unique:usuario,usuario_usuario|max:20',
            'usuario_clave'    => 'required|min:4',
            'rol'              => 'required'
        ]);

        Usuario::create([
            'usuario_nombre'   => $request->usuario_nombre,
            'usuario_apellido' => $request->usuario_apellido,
            'usuario_usuario'  => $request->usuario_usuario,
            'usuario_clave'    => Hash::make($request->usuario_clave),
            'rol'              => $request->rol,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    // 4. MOSTRAR FORMULARIO DE EDICIÓN
    public function edit($id)
    {
        // Buscamos al usuario por su ID personalizado
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    // 5. ACTUALIZAR DATOS
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'usuario_nombre'   => 'required|max:40',
            'usuario_apellido' => 'required|max:40',
            'usuario_usuario'  => 'required|max:20|unique:usuario,usuario_usuario,'.$id.',usuario_id',
            'rol'              => 'required'
        ]);

        $usuario->usuario_nombre = $request->usuario_nombre;
        $usuario->usuario_apellido = $request->usuario_apellido;
        $usuario->usuario_usuario = $request->usuario_usuario;
        $usuario->rol = $request->rol;

        // Solo actualiza la clave si el usuario escribió algo en ese campo
        if ($request->filled('usuario_clave')) {
            $usuario->usuario_clave = Hash::make($request->usuario_clave);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado con éxito.');
    }
}