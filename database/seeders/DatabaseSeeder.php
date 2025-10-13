<?php

namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // 1. Desactivar temporalmente la verificación de claves foráneas
        // Esto permite hacer TRUNCATE en tablas que tienen dependencias.
        Schema::disableForeignKeyConstraints();

        // 2. Ejecutar todos los seeders
        // El orden es importante:
        // Primero, los seeders de usuarios y administradores.
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);

        // Luego, los seeders de datos maestros sin dependencias cruzadas, 
        // como Marcas y Categorías (estas están separadas).
        // (Hay que asegurarse de que los seeders de productos incluyan Brands y Categories)
        $this->call(ProductSeeder::class);

        // 3. Reactivar la verificación de claves foráneas
        Schema::enableForeignKeyConstraints();
    }
}
