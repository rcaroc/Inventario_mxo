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
        // 1. Validamos los datos que vienen del formulario (name y password)
        $credentials = $request->validate([
            'name'     => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // 2. Intentamos autenticar usando la columna 'name' de tu tabla users
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirige a la ruta 'home' (tu vista inicio)
            return redirect()->intended('home');
        }

        // 3. Si falla, regresa con error al campo 'name'
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