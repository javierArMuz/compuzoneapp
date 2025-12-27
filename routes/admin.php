<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;

/*
|--------------------------------------------------------------------------
| Rutas del Administrador (Admin Panel)
|--------------------------------------------------------------------------
*/


// Rutas para el formulario de login (accesibles para no autenticados)
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');

// Grupo de rutas protegidas por middleware 'auth:admin'
Route::middleware(['auth:admin'])->group(function () {
  // Dashboard del panel de administración
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // Rutas para el CRUD de Productos (Ejemplo de sintaxis completa)
  Route::get('/products', [ProductController::class, 'index'])->name('products.index');
  Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
  Route::post('/products', [ProductController::class, 'store'])->name('products.store');
  Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
  Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
  Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
  Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

  // Rutas para el CRUD de Categorías
  Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
  Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
  Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
  Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
  Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

  // Rutas para el CRUD de Marcas
  Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
  Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
  Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
  Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
  Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

  // Rutas para el CRUD de Usuarios
  Route::get('/users', [UserController::class, 'index'])->name('users.index');
  Route::post('/users', [UserController::class, 'store'])->name('users.store');
  Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
  Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
  Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
  Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

  // Rutas para Pedidos
  Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
  Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
  Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');


  // Ruta para cerrar sesión
  Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

  // ¡AÑADE ESTA RUTA DE PRUEBA!
  Route::get('/simple-test', function () {
    return 'Si ves esto, la autenticación falló.';
  })->name('simple.test');
});
