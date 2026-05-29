<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
    protected $primaryKey = 'stock_id';
    protected $fillable = ['producto_id', 'cantidad'];

    // Relación inversa: Un stock pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}