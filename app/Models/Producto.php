<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'producto_id';

    protected $fillable = [
        'modelo_id',
        'usuario_id',
        'producto_nombre',
        'producto_talla',
        'producto_color',
        'producto_proveedor' // Aunque sea opcional, debe estar aquí
    ];

    // Relación: Un producto pertenece a un modelo
    public function modelo()
    {
        return $this->belongsTo(Modelo::class, 'modelo_id', 'modelo_id');
    }

        public function stock()
    {
        // Un producto tiene un registro de stock
        return $this->hasOne(Stock::class, 'producto_id');
    }
}