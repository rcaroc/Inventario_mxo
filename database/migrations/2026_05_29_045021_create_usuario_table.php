<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
        Schema::create('usuario', function (Blueprint $table) {
            // Cambiamos id() por id('usuario_id') para que coincida con tu SQL original
            $table->id('usuario_id'); 
            $table->string('usuario_nombre', 40);
            $table->string('usuario_apellido', 40);
            $table->string('usuario_usuario', 20)->unique();
            $table->string('usuario_clave', 200);
            // El rol con sus opciones permitidas
            $table->enum('rol', ['administrador', 'inventario', 'ventas'])->default('ventas');
            // timestamps() crea automáticamente fecha_creacion (created_at) y fecha_actualizacion (updated_at)
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
