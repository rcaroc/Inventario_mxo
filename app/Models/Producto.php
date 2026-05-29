<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'producto_id';

    protected $fillable = [
        'modelo_id',
        'color',
        'talla',
        'stock'
    ];

    // Relación: Un producto pertenece a un modelo
    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'modelo_id', 'modelo_id');
    }
}