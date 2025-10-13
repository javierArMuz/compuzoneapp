<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contraseña simple para el admin de prueba
        $plainPassword = 123456789;

        // Limpiar la tabla de administradores
        DB::table('admins')->truncate();

        // 1. Crear Usuario Administrador para pruebas (Acceso al módulo /admin)
        DB::table('admins')->insert([
            'name' => 'Admin',
            'email' => 'admin@compuzone.com',
            'password' => Hash::make($plainPassword), // Contraseña: password
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Opcional: Crear otro administrador de soporte
        DB::table('admins')->insert([
            'name' => 'Soporte TI',
            'email' => 'support@compuzone.com',
            'password' => Hash::make($plainPassword),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
