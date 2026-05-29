<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistema de Inventario MXO (UCV)
|--------------------------------------------------------------------------
*/

// RUTA PRINCIPAL: Carga la vista 'inicio' y le pasa los productos de la DB
Route::get('/', function () {
    try {
        // Intentamos obtener los productos de la tabla 'producto'
        $productos = DB::table('producto')->get();
        
        // Retornamos la vista 'inicio' (asegúrate de que el archivo sea inicio.blade.php)
        return view('inicio', ['productos' => $productos]);
        
    } catch (\Exception $e) {
        // Si hay un error de conexión, lo mostramos para debug
        return "Error al conectar con la base de datos: " . $e->getMessage();
    }
})->name('inicio');

// RUTA DE MODELOS: Definida para evitar el error "Route [modelos.index] not defined"
Route::get('/modelos', function () {
    $modelos = DB::table('modelo')->get();
    return "Pantalla de Modelos (En desarrollo). Registros encontrados: " . $modelos->count();
})->name('modelos.index');

// RUTA DE USUARIOS: Definida para evitar errores en el menú/navegación
Route::get('/usuarios', function () {
    $usuarios = DB::table('usuario')->get();
    return "Pantalla de Usuarios (En desarrollo). Usuarios registrados: " . $usuarios->count();
})->name('usuarios.index');

// RUTA DE PRODUCTOS: Por si tu menú también la pide
Route::get('/productos', function () {
    return redirect()->route('inicio');
})->name('productos.index');

/**
 * RUTA DE DEPURACIÓN (Opcional)
 * Puedes entrar a tu-app.render.com/debug para ver si la DB responde
 */
Route::get('/debug', function () {
    $tablas = DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
    return response()->json([
        'mensaje' => 'Conexión Exitosa',
        'tablas_existentes' => $tablas
    ]);
});