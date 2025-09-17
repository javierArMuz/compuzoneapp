<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Ejecuta la migración
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Clave primaria autoincremental
            $table->string('name', 100); // Nombre de la categoría, obligatorio
            $table->text('description')->nullable(); // Descripción opcional
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    // Reversa la migración
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
