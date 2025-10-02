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
		Schema::table('users', function (Blueprint $table) {
			// Nuevos campos
			$table->timestamp('email_verified_at')->nullable()->after('email'); // Necesario para autenticación por defecto
			$table->string('password')->after('email_verified_at'); // ¡CAMPO CRUCIAL!
			$table->rememberToken()->after('registration_date'); // Para "Recordarme"

			// Modificar campo existente
			$table->string('first_name', 100)->nullable(false)->change();
			$table->string('email', 100)->nullable(false)->change();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::table('users', function (Blueprint $table) {
			// Eliminar nuevos campos
			$table->dropColumn(['email_verified_at', 'password']);

			// Volver a permitir nulos
			$table->string('first_name', 100)->nullable()->change();
			$table->string('email', 100)->nullable()->change();
		});
	}
};
