<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contraseña simple para el usuario cliente de prueba
        $plainPassword = 123456789;

        // Limpiar la tabla de usuarios
        DB::table('users')->truncate();

        // 1. Crear Usuario Cliente (Para pruebas de sesión y Carrito)
        DB::table('users')->insert([
            'first_name' => 'Cliente',
            'email' => 'cliente@compuzone.com',
            'password' => Hash::make($plainPassword), // Contraseña: password
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Crear un segundo cliente
        DB::table('users')->insert([
            'first_name' => 'Invitado',
            'email' => 'invitado@compuzone.com',
            'password' => Hash::make($plainPassword),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
