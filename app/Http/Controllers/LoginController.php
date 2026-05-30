<?php

namespace App\Http\Controllers;

// Importamos lo necesario
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de login ubicado en resources/views/auth/login.blade.php
     */
    public function showLoginForm() 
    {
        return view('auth.login');
    }

    /**
     * Procesa el intento de login
     */
public function login(Request $request)
{
    // Validamos lo que viene del formulario
    $request->validate([
        'name'     => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    // Intentamos loguear usando tus columnas personalizadas
    // 'usuario_usuario' es la columna de la DB
    // 'usuario_clave' se maneja automáticamente por el método getAuthPassword que pusimos arriba
    $credentials = [
        'usuario_usuario' => $request->name, 
        'password'        => $request->password
    ];

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('home');
    }

    return back()->withErrors([
        'name' => 'Las credenciales no coinciden con nuestros registros.',
    ])->withInput();
}

    /**
     * Cierra la sesión y redirige al login morado
     */
    public function logout(Request $request)
    {
        Auth::logout(); 

        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 

        return redirect('/login'); 
    }
}