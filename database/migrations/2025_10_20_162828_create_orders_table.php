<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 * Crea la tabla principal de órdenes.
	 */
	public function up(): void
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->id();
			// Clave foránea al usuario que realiza la compra
			$table->foreignId('user_id')->constrained('users')->onDelete('cascade');
			$table->string('order_number')->unique();
			$table->decimal('total_amount', 10, 2);
			$table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('completed'); // Asumimos completado tras el checkout
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('orders');
	}
};
