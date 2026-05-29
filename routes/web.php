<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; // IMPORTANTE: Para usar la base de datos

// --- INICIO ---
Route::get('/', function () { 
    return view('inicio'); 
})->name('home');

// --- USUARIOS ---
Route::prefix('usuarios')->group(function () {
    Route::get('/lista', function () { 
        $usuarios = DB::table('usuario')->get(); // Trae todo de la tabla 'usuario'
        return view('usuarios.index', compact('usuarios')); 
    })->name('usuarios.index');

    Route::get('/crear', function () { return view('usuarios.create'); })->name('usuarios.create');
    Route::post('/guardar', function () { return "Guardado"; })->name('usuarios.store');
});

// --- CATÁLOGO ---
Route::prefix('catalogo')->group(function () {
    Route::get('/modelos', function () { 
        $modelos = DB::table('modelo')->get(); // Trae todo de la tabla 'modelo'
        return view('modelos.index', compact('modelos')); 
    })->name('modelos.index');

    Route::get('/modelos/nuevo', function () { return view('modelos.create'); })->name('modelos.create');

    Route::get('/productos', function () { 
        $productos = DB::table('producto')->get(); // Trae todo de la tabla 'producto'
        return view('productos.index', compact('productos')); 
    })->name('productos.index');

    Route::get('/productos/nuevo', function () { return view('productos.create'); })->name('productos.create');
});

// --- MOVIMIENTOS ---
Route::prefix('movimientos')->group(function () {
    Route::get('/entrada', function () { return view('movimientos.entrada'); })->name('movimientos.entrada');
    Route::get('/salida', function () { return view('movimientos.salida'); })->name('movimientos.salida');
    Route::get('/historial', function () { return view('movimientos.historial'); })->name('movimientos.historial');
});

// --- REPORTES ---
Route::prefix('reportes')->group(function () {
    Route::get('/stock-modelo', function () { return view('reportes.stock_modelo'); })->name('reportes.modelo');
    Route::get('/stock-talla-color', function () { return view('reportes.stock_talla'); })->name('reportes.talla');
});

Route::post('/logout', function () { return redirect('/'); })->name('logout');