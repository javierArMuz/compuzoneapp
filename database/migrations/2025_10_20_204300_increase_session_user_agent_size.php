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
		Schema::table('sessions', function (Blueprint $table) {
			// Cambia la columna existente a 'text' para que admita User Agents largos
			$table->text('user_agent')->change();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('sessions', function (Blueprint $table) {
			// Revierte el cambio a un string más corto, si es necesario.
			// Usaremos 255 como un valor estándar en lugar de 120.
			$table->string('user_agent', 255)->change();
		});
	}
};
