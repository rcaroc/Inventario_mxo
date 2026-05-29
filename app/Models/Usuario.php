<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model {
    protected $table = 'usuario'; // Nombre real en Supabase
    protected $primaryKey = 'usuario_id'; // Tu llave primaria personalizada
}