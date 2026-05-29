<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// --- RUTA RAÍZ (DASHBOARD) ---
Route::get('/', function () {
    return view('inicio'); 
})->name('home');

// --- GRUPO USUARIOS (Con Lista y Nuevo) ---
Route::prefix('usuarios')->group(function () {
    
    // Opción: Lista de usuarios
    Route::get('/lista', function () {
        $usuarios = DB::table('usuario')->get();
        return view('usuarios.index', ['usuarios' => $usuarios]);
    })->name('usuarios.index');

    // Opción: Nuevo usuario
    Route::get('/nuevo', function () {
        return view('usuarios.create');
    })->name('usuarios.create');
    
    // Ruta para procesar el guardado del nuevo usuario
    Route::post('/guardar', function () {
        return "Procesando nuevo usuario...";
    })->name('usuarios.store');
});

// --- GRUPO CATÁLOGO (MODELOS) ---
Route::prefix('modelos')->group(function () {
    Route::get('/', function () { 
        $modelos = DB::table('modelo')->get();
        return view('modelos.index', compact('modelos')); 
    })->name('modelos.index');
    
    Route::get('/crear', function () { 
        return view('modelos.create'); 
    })->name('modelos.create');
});

// --- OTRAS RUTAS NECESARIAS ---
Route::get('/movimientos', function () { return view('movimientos.index'); })->name('movimientos.index');
Route::get('/reportes', function () { return view('reportes.index'); })->name('reportes.index');

// --- CERRAR SESIÓN ---
Route::post('/logout', function () {
    return redirect('/');
})->name('logout');