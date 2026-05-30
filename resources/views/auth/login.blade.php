<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Mostrar la vista que ya tienes en auth/login.blade.php
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validamos que el usuario escriba algo
        $credentials = $request->validate([
            'name' => ['required'], // Cambia 'name' por 'email' si usas correos para entrar
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Si entra bien, lo mandamos al inicio
            return redirect()->intended('home');
        }

        // Si falla, regresa con error
        return back()->withErrors([
            'name' => 'El usuario o la contraseña no coinciden.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}