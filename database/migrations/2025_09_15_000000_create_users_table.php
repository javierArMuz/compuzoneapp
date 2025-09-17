<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    // Ejecuta la migración
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // int(11), PRIMARY KEY, AUTO_INCREMENT
            $table->string('first_name', 100)->nullable(); // varchar(100), NULL
            $table->string('last_name', 100)->nullable();  // varchar(100), NULL
            $table->string('email', 100)->nullable()->unique(); // varchar(100), NULL, UNIQUE
            $table->string('phone', 15)->nullable(); // varchar(15), NULL
            $table->text('address')->nullable(); // text, NULL
            $table->date('registration_date')->nullable(); // date, NULL
            $table->timestamps(); // created_at y updated_at
        });
    }

    // Revierte la migración
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
