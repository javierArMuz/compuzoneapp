<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  // Ejecuta la migración
  public function up(): void
  {
    Schema::create('products', function (Blueprint $table) {
      $table->id(); // Clave primaria autoincremental
      $table->string('name', 100); // Nombre del producto, obligatorio
      $table->text('description')->nullable(); // Descripción opcional
      $table->foreignId('brand_id') // Relación con la tabla brands
        ->constrained()
        ->onDelete('cascade'); // Elimina productos si la marca se elimina
      $table->string('model', 100)->nullable(); // Modelo del producto, opcional
      $table->decimal('price', 10, 2)->default(0); // Precio con dos decimales
      $table->integer('stock')->default(0); // Cantidad disponible
      $table->foreignId('category_id') // Relación con la tabla categories
        ->constrained()
        ->onDelete('cascade'); // Elimina productos si la categoría se elimina
      $table->string('image_url', 255)->nullable(); // URL de la imagen del producto
      $table->boolean('is_active')->default(true); // Estado del producto (activo/inactivo)
      $table->timestamps(); // Campos created_at y updated_at
    });
  }

  // Reversa la migración
  public function down(): void
  {
    Schema::dropIfExists('products');
  }
};
