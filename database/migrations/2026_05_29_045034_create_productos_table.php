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
    Schema::create('producto', function (Blueprint $table) {
        $table->id('producto_id');
        // Relaciones
        $table->foreignId('modelo_id')->constrained('modelo', 'modelo_id');
        $table->foreignId('usuario_id')->constrained('usuario', 'usuario_id');
        
        $table->string('producto_nombre', 70);
        $table->string('producto_talla', 10)->nullable();
        $table->string('producto_color', 30)->nullable();
        $table->string('producto_proveedor', 100)->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
