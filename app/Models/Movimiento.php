<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    // 1. Nombre real de la tabla en Supabase
    protected $table = 'movimiento';

    // 2. Tu llave primaria personalizada
    protected $primaryKey = 'movimiento_id';

    // 3. Campos que se pueden llenar masivamente
    protected $fillable = [
        'producto_id',
        'usuario_id',
        'tipo',
        'cantidad',
        'descripcion'
    ];

    // RELACIONES: Esto te servirá para tu informe de la UCV (Integridad Referencial)

    // Un movimiento pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Un movimiento fue realizado por un usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}