<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;

// Home (por defecto)
Route::get('/', fn() => view('welcome'))->name('home');

// Grupo /admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard simple
    Route::get('/', fn() => view('layouts.admin'))->name('dashboard');
    // CRUD de categorías bajo /admin/categories
    Route::resource('categories', CategoryController::class)
        ->parameters(['categories' => 'category']); // por claridad en el {category}
    // CRUD de marcas bajo /admin/brands
    Route::resource('brands', BrandController::class);
    // CRUD de productos bajo /admin/products
    Route::resource('products', ProductController::class);
});
