<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Modelo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Limpiar los datos existentes en las tablas
        // Desactivamos temporalmente las restricciones de llaves foráneas para poder vaciar
        // En PostgreSQL (Supabase) se usa 'CASCADE' para limpiar tablas relacionadas
        DB::statement('TRUNCATE TABLE usuario RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE modelos RESTART IDENTITY CASCADE');

        // 2. Crear el Usuario Administrador (Ahora no dará error porque la tabla está vacía)
        Usuario::create([
            'usuario_nombre'   => 'Admin',
            'usuario_apellido' => 'Sistema',
            'usuario_usuario'  => 'admin_ucv',
            'usuario_clave'    => Hash::make('admin123'),
            'rol'              => 'administrador'
        ]);

        // 3. Crear Modelos de ejemplo para tu Catálogo
        Modelo::create([
            'modelo_nombre' => 'Laptop HP ProBook',
            'modelo_marca'  => 'HP'
        ]);

        Modelo::create([
            'modelo_nombre' => 'Monitor Dell 24"',
            'modelo_marca'  => 'Dell'
        ]);

        $this->command->info('Tablas vaciadas y datos nuevos sembrados correctamente.');
    }
}