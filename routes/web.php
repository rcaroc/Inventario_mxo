<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { return view('inicio'); })->name('home');

Route::prefix('usuarios')->group(function () {
    Route::get('/lista', function () { return view('usuarios.index'); })->name('usuarios.index');
    Route::get('/crear', function () { return view('usuarios.create'); })->name('usuarios.create');
    Route::post('/guardar', function () { return "Guardado"; })->name('usuarios.store');
});

Route::prefix('catalogo')->group(function () {
    Route::get('/modelos', function () { return view('modelos.index'); })->name('modelos.index');
    Route::get('/modelos/nuevo', function () { return view('modelos.create'); })->name('modelos.create');
    Route::get('/productos', function () { return view('productos.index'); })->name('productos.index');
    Route::get('/productos/nuevo', function () { return view('productos.create'); })->name('productos.create');
});

Route::prefix('movimientos')->group(function () {
    Route::get('/entrada', function () { return view('movimientos.entrada'); })->name('movimientos.entrada');
    Route::get('/salida', function () { return view('movimientos.salida'); })->name('movimientos.salida');
    Route::get('/historial', function () { return view('movimientos.historial'); })->name('movimientos.historial');
});

Route::prefix('reportes')->group(function () {
    Route::get('/stock-modelo', function () { return view('reportes.stock_modelo'); })->name('reportes.modelo');
    Route::get('/stock-talla-color', function () { return view('reportes.stock_talla'); })->name('reportes.talla');
});

Route::post('/logout', function () { return redirect('/'); })->name('logout');