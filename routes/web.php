<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistema de Inventario MXO
|--------------------------------------------------------------------------
*/

// --- INICIO (DASHBOARD) ---
Route::get('/', function () {
    return view('inicio'); 
})->name('home');

// --- GRUPO: USUARIO ---
Route::prefix('usuarios')->group(function () {
    // Lista de Usuarios
    Route::get('/lista', function () { 
        return view('usuarios.index'); 
    })->name('usuarios.index');

    // Crear Usuario
    Route::get('/crear', function () { 
        return view('usuarios.create'); 
    })->name('usuarios.create');
    
    // Guardar Usuario (POST)
    Route::post('/guardar', function () { 
        return "Usuario guardado correctamente"; 
    })->name('usuarios.store');
});

// --- GRUPO: CATÁLOGO ---
Route::prefix('catalogo')->group(function () {
    // Modelos
    Route::get('/modelos', function () { return view('modelos.index'); })->name('modelos.index');
    Route::get('/modelos/nuevo', function () { return view('modelos.create'); })->name('modelos.create');
    
    // Productos
    Route::get('/productos', function () { return view('productos.index'); })->name('productos.index');
    Route::get('/productos/nuevo', function () { return view('productos.create'); })->name('productos.create');
});

// --- GRUPO: MOVIMIENTO ---
Route::prefix('movimientos')->group(function () {
    Route::get('/entrada', function () { 
        return view('movimientos.entrada'); 
    })->name('movimientos.entrada');

    Route::get('/salida', function () { 
        return view('movimientos.salida'); 
    })->name('movimientos.salida');

    Route::get('/historial', function () { 
        return view('movimientos.historial'); 
    })->name('movimientos.historial');
});

// --- GRUPO: REPORTE ---
Route::prefix('reportes')->group(function () {
    // Stock por modelo
    Route::get('/stock-modelo', function () { 
        return view('reportes.stock_modelo'); 
    })->name('reportes.modelo');

    // Stock por talla y color
    Route::get('/stock-talla-color', function () { 
        return view('reportes.stock_talla'); 
    })->name('reportes.talla');
});

// --- SESIÓN ---
Route::post('/logout', function () {
    // Lógica temporal para redireccionar al salir
    return redirect()->route('home');
})->name('logout');

// --- RUTA DE PRUEBA DB (Opcional para debug) ---
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "Conexión a Supabase exitosa. Base de datos: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "Error en la conexión: " . $e->getMessage();
    }
});