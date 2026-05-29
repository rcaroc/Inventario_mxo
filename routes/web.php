<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    try {
        // 1. Verificar conexión
        DB::connection()->getPdo();
        $dbStatus = "✅ Conexión a Supabase Exitosa";

        // 2. Intentar leer una tabla real (CAMBIA 'productos' POR TU TABLA)
        $tabla = 'productos'; 
        $cantidad = DB::table($tabla)->count();
        $datosStatus = "📊 La tabla '$tabla' tiene $cantidad registros.";

    } catch (\Exception $e) {
        $dbStatus = "❌ Error: " . $e->getMessage();
        $datosStatus = "No se pudo leer la tabla.";
    }

    return "
    <div style='font-family: sans-serif; text-align: center; padding: 50px;'>
        <h1>🚀 Sistema de Inventario MXO</h1>
        <p style='font-size: 1.2em;'><strong>$dbStatus</strong></p>
        <p style='background: #f4f4f4; padding: 10px; display: inline-block;'>$datosStatus</p>
        <hr style='width: 50%; margin: 20px auto;'>
        <p>Evidencia de Integración de Datos - UCV</p>
    </div>";
});