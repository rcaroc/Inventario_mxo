<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\ReporteController;

// --- INICIO ---
Route::get('/', function () { 
    return view('inicio'); 
})->name('home');

// --- USUARIOS ---
Route::prefix('usuarios')->group(function () {
    Route::get('/lista', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/crear', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/guardar', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/editar/{id}', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/actualizar/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/eliminar/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
});

// --- CATÁLOGO (Modelos y Productos) ---
Route::prefix('catalogo')->group(function () {
    
    // Rutas de Modelos
    Route::get('/modelos', [ModeloController::class, 'index'])->name('modelos.index');
    Route::get('/modelos/nuevo', [ModeloController::class, 'create'])->name('modelos.create');
    Route::post('/modelos/guardar', [ModeloController::class, 'store'])->name('modelos.store');
    Route::get('/modelos/editar/{id}', [ModeloController::class, 'edit'])->name('modelos.edit');
    Route::put('/modelos/actualizar/{id}', [ModeloController::class, 'update'])->name('modelos.update'); // Añadida para el futuro
    Route::delete('/modelos/eliminar/{id}', [ModeloController::class, 'destroy'])->name('modelos.destroy');

    // Rutas de Productos (Ahora dentro del grupo correctamente)
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/productos/nuevo', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/productos/guardar', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/productos/editar/{id}', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::delete('/productos/eliminar/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');
});

// --- MOVIMIENTOS ---
Route::prefix('movimientos')->group(function () {
    // Entradas
    Route::get('/entrada', [MovimientoController::class, 'createEntrada'])->name('movimientos.entrada');
    Route::post('/entrada/guardar', [MovimientoController::class, 'storeEntrada'])->name('movimientos.storeEntrada');
    // Salidas
    Route::get('/salida', [MovimientoController::class, 'createSalida'])->name('movimientos.salida');
    Route::post('/salida/guardar', [MovimientoController::class, 'storeSalida'])->name('movimientos.storeSalida');
    // Historial
    Route::get('/historial', [MovimientoController::class, 'historial'])->name('movimientos.historial');
});

// API para cargar productos dinámicamente (se usa tanto en entrada como en salida)
Route::get('/api/productos-por-modelo/{modelo_id}', [MovimientoController::class, 'getProductosPorModelo']);

// --- REPORTES ---
Route::prefix('reportes')->group(function () {
    Route::get('/stock-modelo', [ReporteController::class, 'stockModelo'])->name('reportes.modelo');
    Route::get('/stock-talla-color', [ReporteController::class, 'stockTalla'])->name('reportes.talla');
});

// --- LOGOUT ---
Route::post('/logout', function () { 
    return redirect('/'); 
})->name('logout');