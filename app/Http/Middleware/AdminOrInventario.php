<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrInventario
{
    public function handle(Request $request, Closure $next): Response
    {
        $rol = strtolower(auth()->user()->rol);
        
        // Solo permite pasar si es administrador o inventario
        if (auth()->check() && ($rol === 'administrador' || $rol === 'inventario')) {
            return $next($request);
        }

        // Si es Ventas, lo rebota al home con un mensaje de error
        return redirect('/home')->with('error', 'No tienes permisos para acceder a esta sección.');
    }
}