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
public function handle($request, Closure $next)
{
    // Si el usuario no es Administrador, lo mandamos al home con un mensaje
    if (auth()->check() && auth()->user()->rol !== 'Administrador') {
        return redirect('/home')->with('error', 'Acceso denegado. Solo administradores.');
    }

    return $next($request);
}
}
