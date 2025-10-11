<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\User\Auth\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Rutas del Usuario Final (Tienda/E-commerce)
|--------------------------------------------------------------------------
*/
// Ruta de inicio (accesible para todos)
Route::get('/', function () {
    return view('welcome');
})->name('home');

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

    // =======================================================
    // RUTAS DE LA TIENDA
    // =======================================================

    // Ruta principal para ver la galería de productos.
    Route::get('dashboard', [ShopController::class, 'index'])->name('dashboard');

    // Formulario de búsqueda y los enlaces.
    Route::get('tienda', [ShopController::class, 'index'])->name('shop.index');

    // Ruta para ver los detalles de un producto.
    Route::get('productos/{product}', [ShopController::class, 'show'])->name('products.show');

    // Rutas del Carrito de Compras

    // El carrito debe ser siempre un método GET
    Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');

    // Agregar un producto (POST, porque modifica la sesión)
    Route::post('/carrito/agregar/{product}', [CartController::class, 'add'])->name('cart.add');

    // Actualizar la cantidad (PUT, porque modifica la sesión)
    Route::put('/carrito/actualizar/{product}', [CartController::class, 'update'])->name('cart.update');

    // Eliminar un producto (DELETE, porque elimina de la sesión)
    Route::delete('/carrito/remover/{product}', [CartController::class, 'remove'])->name('cart.remove');

    // =======================================================

    // Logout
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
