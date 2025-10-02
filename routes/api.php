<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;

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

// Agrupamos todas las rutas de la API de Productos
Route::middleware('api')->group(function () {
  // CRUD RESTful para Productos
  // Las rutas generadas son:
  // GET    /api/products           -> index
  // POST   /api/products           -> store
  // GET    /api/products/{product} -> show
  // PUT    /api/products/{product} -> update
  // DELETE /api/products/{product} -> destroy
  Route::resource('products', ProductApiController::class)->except(['create', 'edit']);
});

// Ruta de ejemplo para el usuario autenticado por token (si se usara Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});
