<?php

namespace App\Http\Controllers;

use App\Models\Usuario; // Importamos el modelo para conectar con Supabase
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Para encriptar claves

class UsuarioController extends Controller
{
    /**
     * 1. LISTAR USUARIOS (index)
     */
    public function index()
    {
        // Traemos todos los usuarios de la tabla 'usuario'
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * 2. MOSTRAR FORMULARIO DE CREACIÓN (create)
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * 3. GUARDAR NUEVO USUARIO (store)
     */
public function store(Request $request)
{
    $request->validate([
        'usuario_nombre'   => 'required|max:40',
        'usuario_apellido' => 'required|max:40',
        'usuario_usuario'  => 'required|unique:usuario,usuario_usuario|max:20',
        'usuario_clave'    => 'required|min:6|confirmed', 
        'rol'              => 'required', 
    ], [
        // Mensajes personalizados
        'usuario_clave.confirmed' => 'Las contraseñas ingresadas no coinciden.',
        'usuario_clave.min' => 'La clave debe tener al menos 6 caracteres.',
        'usuario_usuario.unique' => 'Este nombre de usuario ya está en uso.',
    ]);

    Usuario::create([
        'usuario_nombre'   => $request->usuario_nombre,
        'usuario_apellido' => $request->usuario_apellido,
        'usuario_usuario'  => $request->usuario_usuario,
        'usuario_clave'    => bcrypt($request->usuario_clave),
        'rol'              => $request->rol,
    ]);

    return redirect()->route('usuarios.index')->with('success', '¡Usuario creado con éxito!');
}
    /**
     * 4. MOSTRAR FORMULARIO DE EDICIÓN (edit)
     */
    public function edit($id)
    {
        // Buscamos al usuario por su ID personalizado
        $usuario = Usuario::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * 5. ACTUALIZAR DATOS DEL USUARIO (update)
     */
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        // Validación: El campo unique ignora el ID actual para permitir guardar sin cambiar el nombre de usuario
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

        // Solo cambiamos la clave si el usuario escribió algo en el campo
        if ($request->filled('usuario_clave')) {
            $usuario->usuario_clave = Hash::make($request->usuario_clave);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado con éxito.');
    }

    /**
     * 6. ELIMINAR USUARIO (destroy)
     */
    public function destroy($id)
    {
        // Seguridad: No permitir borrar al administrador principal (ID 1)
        if($id == 1) {
            return redirect()->route('usuarios.index')->with('error', 'No se puede eliminar al administrador principal del sistema.');
        }

        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        // Enviamos la señal 'eliminar' con valor 'ok' para activar el mensaje azul en la vista
        return redirect()->route('usuarios.index')->with('eliminar', 'ok');
    }
}