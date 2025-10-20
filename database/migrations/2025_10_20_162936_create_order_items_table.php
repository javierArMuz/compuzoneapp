<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 * Crea la tabla de ítems de la orden para el detalle del pedido.
	 */
	public function up(): void
	{
		Schema::create('order_items', function (Blueprint $table) {
			$table->id();
			// Clave foránea a la orden a la que pertenece el ítem
			$table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
			// Clave foránea al producto (aunque se podría no usar si se guarda la data estática)
			$table->foreignId('product_id')->constrained('products')->onDelete('restrict');

			$table->integer('quantity');
			$table->decimal('price', 10, 2); // Precio al momento de la compra

			// Campos para guardar el nombre del producto en caso de que se elimine de la tabla 'products'
			$table->string('product_name');
			$table->string('product_image_url')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('order_items');
	}
};
