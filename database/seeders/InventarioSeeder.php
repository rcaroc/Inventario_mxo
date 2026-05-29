<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class InventarioSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Limpiamos solo la tabla de usuarios
        // RESTART IDENTITY reinicia el contador de IDs a 1
        DB::statement('TRUNCATE TABLE usuario RESTART IDENTITY CASCADE');

        // 2. Creamos el usuario administrador
        // Asegúrate de que estos campos existan en tu tabla 'usuario'
        Usuario::create([
            'usuario_nombre'   => 'Admin',
            'usuario_apellido' => 'Sistema',
            'usuario_usuario'  => 'admin_ucv',
            'usuario_clave'    => Hash::make('admin123'),
            'rol'              => 'administrador'
        ]);

        $this->command->info('Usuario admin creado. Omitiendo modelos por ahora para evitar errores de columnas.');
    }
}