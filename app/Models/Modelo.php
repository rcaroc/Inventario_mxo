<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelModel; // Renombramos el core para evitar conflicto

class Modelo extends LaravelModel
{
    use HasFactory;

    protected $table = 'modelo'; // Tu tabla en Supabase
    protected $primaryKey = 'modelo_id';
    public $timestamps = true;

    protected $fillable = [
        'modelo_nombre',
        'modelo_ubicacion'
    ];
}