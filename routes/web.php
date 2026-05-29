<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    try {
        // Intenta conectar a la base de datos de Supabase
        DB::connection()->getPdo();
        $dbStatus = "✅ Conexión a Supabase establecida correctamente.";
    } catch (\Exception $e) {
        $dbStatus = "❌ Error de conexión: " . $e->getMessage();
    }

    return "
    <div style='font-family: sans-serif; text-align: center; padding: 50px;'>
        <h1>🚀 Sistema de Inventario MXO</h1>
        <p style='font-size: 1.2em;'>Estado: <strong>$dbStatus</strong></p>
        <hr style='width: 50%; margin: 20px auto;'>
        <p>Proyecto de Ingeniería de Sistemas - VII Ciclo</p>
    </div>";
});