<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// --- INICIO ---
Route::get('/', function () {
    return view('inicio'); 
})->name('home');

// --- MENÚ: USUARIO ---
Route::prefix('usuarios')->group(function () {
    // Opción: Lista de Usuarios
    Route::get('/lista', function () {
        $usuarios = DB::table('usuario')->get();
        return view('usuarios.index', compact('usuarios'));
    })->name('usuarios.index');

    // Opción: Crear Usuario (Nuevo Usuario)
    Route::get('/crear', function () {
        return view('usuarios.create');
    })->name('usuarios.create');
});

// --- MENÚ: CATÁLOGO ---
Route::prefix('catalogo')->group(function () {
    
    // Opción: Lista de Modelos
    Route::get('/modelos', function () {
        $modelos = DB::table('modelo')->get();
        return view('modelos.index', compact('modelos'));
    })->name('modelos.index');

    // Opción: Nuevo Modelo
    Route::get('/modelos/nuevo', function () {
        return view('modelos.create');
    })->name('modelos.create');

    // Opción: Lista de Productos
    Route::get('/productos', function () {
        $productos = DB::table('producto')->get();
        return view('productos.index', compact('productos'));
    })->name('productos.index');

    // Opción: Nuevo Producto
    Route::get('/productos/nuevo', function () {
        return view('productos.create');
    })->name('productos.create');
});

// --- MENÚ: MOVIMIENTO ---
Route::get('/movimientos', function () {
    return view('movimientos.index');
})->name('movimientos.index');

// --- MENÚ: REPORTE ---
Route::get('/reportes', function () {
    return view('reportes.index');
})->name('reportes.index');

// --- CIERRE DE SESIÓN ---
Route::post('/logout', function () {
    return redirect('/');
})->name('logout');