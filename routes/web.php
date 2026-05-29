<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Esta será la ruta principal que cargará tu diseño
Route::get('/', function () {
    // Intentamos obtener los productos para pasarlos a la vista
    $productos = DB::table('producto')->get();
    
    return view('inicio', ['productos' => $productos]);
});

// Puedes mantener esta ruta solo para pruebas rápidas si quieres
Route::get('/debug-db', function () {
    return DB::table('usuario')->get();
});