public function run(): void
{
    // 1. COMENTA O BORRA EL TRUNCATE
    // Ya no borraremos la tabla cada vez
    // DB::statement('TRUNCATE TABLE usuario RESTART IDENTITY CASCADE');

    // 2. USA updateOrCreate
    // Esto busca si existe 'admin_ucv'. Si existe, lo actualiza. Si no, lo crea.
    // De esta forma NO toca a los demás usuarios que ya creaste (como Erick).
    Usuario::updateOrCreate(
        ['usuario_usuario' => 'admin_ucv'], 
        [
            'usuario_nombre'   => 'Admin',
            'usuario_apellido' => 'Sistema',
            'usuario_clave'    => Hash::make('admin123'),
            'rol'              => 'administrador'
        ]
    );

    $this->command->info('Seeder ejecutado: El administrador ha sido verificado/creado sin borrar al resto.');
}