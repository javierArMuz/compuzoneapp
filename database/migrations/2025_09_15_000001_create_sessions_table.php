<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
  // Ejecuta la migración
  public function up(): void
  {
    Schema::create('sessions', function (Blueprint $table) {
      $table->string('id', 255)->primary(); // varchar(255), PRIMARY KEY
      $table->unsignedInteger('user_id')->nullable(); // int(10), NULL
      $table->string('ip_address', 45)->nullable(); // varchar(45), NULL
      $table->string('user_agent', 120)->nullable(); // varchar(120), NULL
      $table->longText('payload')->nullable(); // longtext, NULL
      $table->unsignedInteger('last_activity')->nullable(); // int(10), NULL

      // Índices adicionales
      $table->index('user_id', 'sessions_user_id_index');
      $table->index('last_activity', 'sessions_last_activity_index');
    });
  }

  // Revierte la migración
  public function down(): void
  {
    Schema::dropIfExists('sessions');
  }
}
