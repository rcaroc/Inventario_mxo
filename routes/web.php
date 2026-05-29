<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// --- RUTA PRINCIPAL ---
Route::get('/', function () {
    try {
        $productos = DB::table('producto')->get();
        return view('inicio', ['productos' => $productos]);
    } catch (\Exception $e) {
        return "Error de conexión: " . $e->getMessage();
    }
})->name('inicio');

// --- RUTAS PARA MODELOS (Para que no fallen los botones de la vista) ---
Route::prefix('modelos')->group(function () {
    Route::get('/', function () { return "Lista de Modelos"; })->name('modelos.index');
    Route::get('/crear', function () { return "Formulario para crear modelo"; })->name('modelos.create');
    Route::post('/', function () { return "Guardando modelo..."; })->name('modelos.store');
});

// --- RUTAS PARA PRODUCTOS ---
Route::prefix('productos')->group(function () {
    Route::get('/', function () { return redirect()->route('inicio'); })->name('productos.index');
    Route::get('/crear', function () { return "Formulario para crear producto"; })->name('productos.create');
    Route::post('/', function () { return "Guardando producto..."; })->name('productos.store');
});

// --- RUTAS PARA USUARIOS ---
Route::prefix('usuarios')->group(function () {
    Route::get('/', function () { return "Lista de Usuarios"; })->name('usuarios.index');
    Route::get('/crear', function () { return "Formulario para crear usuario"; })->name('usuarios.create');
});