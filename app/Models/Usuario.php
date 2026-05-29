<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    // Le decimos el nombre exacto de tu tabla
    protected $table = 'usuario'; 

    // Le decimos cuál es tu llave primaria personalizada
    protected $primaryKey = 'usuario_id'; 

    // Campos que permitimos que se guarden desde el formulario
    protected $fillable = [
        'usuario_nombre', 
        'usuario_apellido', 
        'usuario_usuario', 
        'usuario_clave', 
        'rol'
    ];

    // Si no usas los campos created_at y updated_at, pon esto en false. 
    // Pero como tu migración los tiene, déjalo así o bórralo.
    public $timestamps = true;
}