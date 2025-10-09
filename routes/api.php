<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\BrandApiController;
use App\Http\Controllers\Api\CategoryApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Agrupamos todas las rutas de la API de CompuzoneApp
Route::middleware('api')->group(function () {
  // CRUD RESTful para Productos
  // Endpoints: /api/products
  Route::resource('products', ProductApiController::class)->except(['create', 'edit']);

  // CRUD RESTful para Marcas (Brands)
  // Endpoints: /api/brands
  Route::resource('brands', BrandApiController::class)->except(['create', 'edit']);

  // CRUD RESTful para Categorías (Categories)
  // Endpoints: /api/categories
  Route::resource('categories', CategoryApiController::class)->except(['create', 'edit']);
}); // CIERRE DEL GRUPO DE RUTAS

// Ruta de ejemplo para el usuario autenticado por token (si se usara Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});
