<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar tablas antes de sembrar (¡OJO! Esto borra todos los datos)
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('brands')->truncate();

        // 1. Crear Categorías
        $desktop = Category::create(['name' => 'Computadores de Escritorio']);
        $laptops = Category::create(['name' => 'Portátiles Gaming']);
        $accessories = Category::create(['name' => 'Accesorios']);

        // 2. Crear Marcas
        $intel = Brand::create(['name' => 'Intel']);
        $amd = Brand::create(['name' => 'AMD']);
        $logitech = Brand::create(['name' => 'Logitech']);

        // 3. Crear Productos de Prueba

        // Producto 1: Usado en Caso de Prueba 2 (ID = 1 si no hay otros datos)
        Product::create([
            'name' => 'PC Gaming i7 Extreme',
            // 'slug' => 'pc-gaming-i7',
            'description' => 'Un computador de alto rendimiento ideal para eSports y desarrollo.',
            'price' => 5999000.00, // Precio en pesos colombianos
            'stock' => 15,
            'category_id' => $desktop->id,
            'brand_id' => $intel->id,
            'is_active' => true,
        ]);

        // Producto 2: Laptop
        Product::create([
            'name' => 'Laptop Gamer RTX 4070',
            // 'slug' => 'laptop-rtx-4070',
            'description' => 'Portátil delgado y potente con gráficos de última generación.',
            'price' => 7500000.00,
            'stock' => 8,
            'category_id' => $laptops->id,
            'brand_id' => $amd->id,
            'is_active' => true,
        ]);

        // Producto 3: Accesorio
        Product::create([
            'name' => 'Mouse Ergonómico G502',
            // 'slug' => 'mouse-g502',
            'description' => 'Mouse de precisión con DPI ajustable y diseño ergonómico.',
            'price' => 250000.00,
            'stock' => 50,
            'category_id' => $accessories->id,
            'brand_id' => $logitech->id,
            'is_active' => true,
        ]);
    }
}
