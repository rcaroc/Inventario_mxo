<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* |--------------------------------------------------------------------------
        | NOTA DE SEGURIDAD
        |--------------------------------------------------------------------------
        | Hemos eliminado el TRUNCATE TABLE ... CASCADE.
        | Esto evita que se borren en cascada tus productos, entradas y salidas 
        | cada vez que el sistema se despliega.
        */

        // 1. Creamos o actualizamos al administrador
        // Si el usuario 'admin_ucv' no existe, lo crea.
        // Si ya existe, solo actualiza sus datos (útil si cambias la clave aquí).
        Usuario::updateOrCreate(
            ['usuario_usuario' => 'admin_ucv'], // Campo de búsqueda único
            [
                'usuario_nombre'   => 'Admin',
                'usuario_apellido' => 'Sistema',
                'usuario_clave'    => Hash::make('admin123'),
                'rol'              => 'administrador'
            ]
        );

        // Puedes agregar aquí otros datos base que sean obligatorios para el sistema
        // sin miedo a que se borre lo que ya tienes en Supabase.

        $this->command->info('✅ Proceso completado:');
        $this->command->info('- El usuario administrador ha sido verificado/creado.');
        $this->command->info('- Se han respetado todos los usuarios, productos y movimientos existentes.');
    }
}