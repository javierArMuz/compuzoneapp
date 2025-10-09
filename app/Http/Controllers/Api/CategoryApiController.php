<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryApiController extends Controller
{
  /**
   * Muestra una lista de todas las categorías (GET /api/categories).
   */
  public function index()
  {
    $categories = Category::all();

    return response()->json([
      'status' => true,
      'message' => 'Lista de categorías recuperada exitosamente.',
      'data' => $categories
    ], 200); // 200 OK
  }

  /**
   * Almacena una nueva categoría (POST /api/categories).
   */
  public function store(Request $request)
  {
    // Reglas de validación para la creación de una categoría (Nombre obligatorio y único)
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255|unique:categories,name',
    ]);

    // Si falla la validación, devuelve 422 (Unprocessable Content)
    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Error de validación al crear la categoría.',
        'errors' => $validator->errors()
      ], 422);
    }

    // Crear la categoría
    $category = Category::create($request->all());

    // Devolver respuesta exitosa (código 201 Created)
    return response()->json([
      'status' => true,
      'message' => 'Categoría creada exitosamente.',
      'data' => $category
    ], 201);
  }

  /**
   * Muestra una categoría específica (GET /api/categories/{id}).
   */
  public function show(string $id)
  {
    $category = Category::find($id);

    if (!$category) {
      return response()->json([
        'status' => false,
        'message' => 'Categoría no encontrada.'
      ], 404); // 404 Not Found
    }

    return response()->json([
      'status' => true,
      'message' => 'Categoría recuperada exitosamente.',
      'data' => $category
    ], 200); // 200 OK
  }

  /**
   * Actualiza una categoría existente (PUT /api/categories/{id}).
   */
  public function update(Request $request, string $id)
  {
    $category = Category::find($id);

    if (!$category) {
      return response()->json([
        'status' => false,
        'message' => 'Categoría no encontrada para actualizar.'
      ], 404); // 404 Not Found
    }

    // Reglas de validación para la ACTUALIZACIÓN:
    // Usamos 'sometimes' para permitir actualizaciones parciales.
    $validator = Validator::make($request->all(), [
      'name' => 'sometimes|string|max:255|unique:categories,name,' . $id,
    ]);

    // Si falla la validación, devuelve 422
    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Error de validación al actualizar la categoría.',
        'errors' => $validator->errors()
      ], 422);
    }

    // Actualizar la categoría
    $category->update($request->all());

    // Devolver respuesta exitosa (código 200 OK)
    return response()->json([
      'status' => true,
      'message' => 'Categoría actualizada exitosamente.',
      'data' => $category
    ], 200);
  }

  /**
   * Elimina una categoría (DELETE /api/categories/{id}).
   */
  public function destroy(string $id)
  {
    $category = Category::find($id);

    if (!$category) {
      return response()->json([
        'status' => false,
        'message' => 'Categoría no encontrada para eliminar.'
      ], 404); // 404 Not Found
    }

    $category->delete();

    // Devolver respuesta sin contenido (código 204 No Content)
    return response()->json(null, 204);
  }
}
