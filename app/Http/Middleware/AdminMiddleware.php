<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
public function handle(Request $request, Closure $next): Response
{
    // Usamos strtolower para comparar siempre en minúsculas
    if (auth()->check() && strtolower(auth()->user()->rol) === 'administrador') {
        return $next($request);
    }

    return redirect('/home')->with('error', 'No tienes permisos de administrador.');
}
}
