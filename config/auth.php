<?php

use App\Models\Usuario; // Cambiado de User a Usuario

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Esta opción define el "guard" de autenticación y el "broker" de 
    | restablecimiento de contraseña predeterminados para tu aplicación.
    |
    */

    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Aquí defines cada "guard" de autenticación. El predeterminado utiliza
    | el almacenamiento de sesión y el proveedor de usuarios Eloquent.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Define cómo se recuperan los usuarios de tu base de datos.
    | Aquí hemos configurado para que use el modelo Usuario.php.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', Usuario::class), // Usando tu modelo Usuario
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'usuarios',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Opciones para el restablecimiento de contraseñas, incluyendo la tabla
    | de tokens y el proveedor de usuarios.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Tiempo antes de que una ventana de confirmación de contraseña expire.
    |
    */

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
