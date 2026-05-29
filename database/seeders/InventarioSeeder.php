<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InventarioSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiar tabla de usuarios (esta sí sabemos que existe por el error anterior)
        DB::statement('TRUNCATE TABLE usuario RESTART IDENTITY CASCADE');

        // 2. Crear el Usuario Administrador
        Usuario::create([
            'usuario_nombre'   => 'Admin',
            'usuario_apellido' => 'Sistema',
            'usuario_usuario'  => 'admin_ucv',
            'usuario_clave'    => Hash::make('admin123'),
            'rol'              => 'administrador'
        ]);

        // 3. Limpiar y sembrar tabla de modelos SOLO si existe
        // Verificamos si se llama 'modelo' o 'modelos'
        $tablaModelos = Schema::hasTable('modelo') ? 'modelo' : (Schema::hasTable('modelos') ? 'modelos' : null);

        if ($tablaModelos) {
            DB::statement("TRUNCATE TABLE $tablaModelos RESTART IDENTITY CASCADE");
            
            // Insertar datos de prueba usando DB para evitar problemas de Modelos
            DB::table($tablaModelos)->insert([
                ['modelo_nombre' => 'Laptop HP ProBook', 'modelo_marca' => 'HP'],
                ['modelo_nombre' => 'Monitor Dell 24"', 'modelo_marca' => 'Dell']
            ]);
        }

        $this->command->info('¡Éxito! Datos limpiados y sembrados.');
    }
}