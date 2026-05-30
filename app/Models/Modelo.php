<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelModel;

class Modelo extends LaravelModel
{
    use HasFactory;

    protected $table = 'modelo'; 
    protected $primaryKey = 'modelo_id';
    public $timestamps = true;

    protected $fillable = [
        'modelo_nombre',
        'modelo_ubicacion' // Asegúrate de que en la base de datos sea 'modelo_ubicacion' o 'ubicacion'
    ];

    // --- AGREGA ESTO ---
    /**
     * Un modelo tiene muchos productos (variantes de talla/color)
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'modelo_id', 'modelo_id');
    }
}