<?php

use Illuminate\Support\Facades\Route;
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
