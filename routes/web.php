<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\User\Auth\UserController;

/*
|--------------------------------------------------------------------------
| Rutas del Usuario Final (Tienda/E-commerce)
|--------------------------------------------------------------------------
*/
// Ruta de inicio (accesible para todos)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// AGREGAR ESTA RUTA TEMPORALMENTE para forzar el cierre de sesión de forma fácil (GET)
Route::get('auth/temp-logout', [UserController::class, 'logout'])->name('auth.temp_logout');

// Rutas de Autenticación de Usuario (Login/Registro)
// Usamos el middleware 'guest' para que solo los usuarios no autenticados puedan acceder a estas páginas.
Route::prefix('auth')->name('auth.')->middleware('guest')->group(function () {
    // Registro
    Route::get('register', [UserController::class, 'create'])->name('register');
    Route::post('register', [UserController::class, 'store'])->name('store');

    // Login
    Route::get('login', [UserController::class, 'login'])->name('login');
    Route::post('login', [UserController::class, 'authenticate'])->name('authenticate');
});

// Rutas para usuarios autenticados (Por ejemplo, un dashboard de cliente)
Route::middleware('auth')->group(function () {
    // Aquí se pueden añadir rutas como:
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');

    // Logout (Esta ruta debe estar protegida para que solo un usuario logueado pueda cerrarla)
    Route::post('auth/logout', [UserController::class, 'logout'])->name('auth.logout');
});

/*
|--------------------------------------------------------------------------
| Rutas del Administrador (Admin Panel)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    // Rutas para el formulario de login (accesibles para no autenticados)
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    // Grupo de rutas protegidas por middleware 'auth:admin'
    Route::middleware(['auth:admin'])->group(function () {
        // Dashboard del panel de administración
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Rutas para el CRUD de productos (Ejemplo de sintaxis completa)
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Rutas para el CRUD de categorías
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Rutas para el CRUD de marcas
        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
        Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

        // Ruta para cerrar sesión
        Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    });
});
