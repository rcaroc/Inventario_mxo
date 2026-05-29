<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Modelo;
use App\Models\Producto;
use App\Models\Stock;
use Illuminate\Support\Facades\Hash;

class InventarioSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Creamos un Usuario Administrador
        $usuario = Usuario::create([
            'usuario_nombre' => 'Admin',
            'usuario_apellido' => 'Sistema',
            'usuario_usuario' => 'admin_ucv',
            'usuario_clave' => Hash::make('12345'), // Encriptada por seguridad
            'rol' => 'administrador'
        ]);

        // 2. Creamos un Modelo de calzado/prenda
        $modelo = Modelo::create([
            'modelo_nombre' => 'Zapatilla Urban v1',
            'modelo_ubicacion' => 'Almacén Central - Estante A1'
        ]);

        // 3. Creamos un Producto vinculado a los dos anteriores
        $producto = Producto::create([
            'modelo_id' => $modelo->modelo_id,
            'usuario_id' => $usuario->usuario_id,
            'producto_nombre' => 'Zapatilla Urban Classic',
            'producto_talla' => '42',
            'producto_color' => 'Negro',
            'producto_proveedor' => 'Proveedor Gamarra SAC'
        ]);

        // 4. Inicializamos el Stock para ese producto
        Stock::create([
            'producto_id' => $producto->producto_id,
            'cantidad' => 50
        ]);
    }
}