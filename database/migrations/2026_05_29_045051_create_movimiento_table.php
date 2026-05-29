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
    Schema::create('movimiento', function (Blueprint $table) {
        $table->id('movimiento_id');
        $table->foreignId('producto_id')->nullable()->constrained('producto', 'producto_id')->onDelete('set null');
        $table->foreignId('usuario_id')->constrained('usuario', 'usuario_id');
        $table->enum('tipo', ['entrada', 'salida']);
        $table->integer('cantidad');
        $table->string('descripcion', 255)->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento');
    }
};
