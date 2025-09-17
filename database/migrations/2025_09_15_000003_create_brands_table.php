<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    // Ejecuta la migración
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id(); // Clave primaria autoincremental
            $table->string('name', 100); // Nombre de la marca, obligatorio
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    // Revierte la migración
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
}
