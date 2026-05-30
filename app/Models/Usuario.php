<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario'; // Tu tabla se llama 'usuario'
    protected $primaryKey = 'usuario_id'; // Tu clave primaria personalizada

    protected $fillable = [
        'usuario_nombre',
        'usuario_apellido',
        'usuario_usuario',
        'usuario_clave',
        'rol',
    ];

    protected $hidden = [
        'usuario_clave', // Ocultar la clave en consultas
    ];

    /**
     * IMPORTANTE: Laravel busca 'password' por defecto. 
     * Con esto le decimos que use 'usuario_clave'.
     */
    public function getAuthPassword()
    {
        return $this->usuario_clave;
    }
}