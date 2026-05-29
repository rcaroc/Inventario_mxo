<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Modelo;
use Illuminate\Support\Facades\Hash;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear o Actualizar el Usuario Administrador
        // Esto evita el error de "Unique violation" que viste en Render
        Usuario::updateOrCreate(
            ['usuario_usuario' => 'admin_ucv'], // Si encuentra este usuario...
            [
                'usuario_nombre' => 'Admin',
                'usuario_apellido' => 'Sistema',
                'usuario_clave' => Hash::make('admin123'), // Cambia 'admin123' por tu clave
                'rol' => 'administrador'
            ]
        );

        // 2. Crear o Actualizar Modelos de ejemplo (Basado en tu Balsamiq)
        // Agregamos algunos para que tu tabla no aparezca vacía al iniciar
        Modelo::updateOrCreate(
            ['modelo_nombre' => 'Laptop HP ProBook'], 
            ['modelo_marca' => 'HP']
        );

        Modelo::updateOrCreate(
            ['modelo_nombre' => 'Monitor Dell 24"'], 
            ['modelo_marca' => 'Dell']
        );

        Modelo::updateOrCreate(
            ['modelo_nombre' => 'Teclado Mecánico RGB'], 
            ['modelo_marca' => 'Logitech']
        );

        $this->command->info('Seeder ejecutado con éxito: Datos actualizados sin duplicados.');
    }
}