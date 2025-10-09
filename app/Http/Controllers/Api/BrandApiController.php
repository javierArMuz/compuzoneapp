<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;

class BrandApiController extends Controller
{
  /**
   * Muestra una lista de todas las marcas (GET /api/brands).
   */
  public function index()
  {
    $brands = Brand::all();

    return response()->json([
      'status' => true,
      'message' => 'Lista de marcas recuperada exitosamente.',
      'data' => $brands
    ], 200); // 200 OK
  }

  /**
   * Almacena una nueva marca (POST /api/brands).
   */
  public function store(Request $request)
  {
    // Reglas de validación para la creación de una marca (Nombre obligatorio y único)
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255|unique:brands,name',
    ]);

    // Si falla la validación, devuelve 422 (Unprocessable Content)
    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Error de validación al crear la marca.',
        'errors' => $validator->errors()
      ], 422);
    }

    // Crear la marca
    $brand = Brand::create($request->all());

    // Devolver respuesta exitosa (código 201 Created)
    return response()->json([
      'status' => true,
      'message' => 'Marca creada exitosamente.',
      'data' => $brand
    ], 201);
  }

  /**
   * Muestra una marca específica (GET /api/brands/{id}).
   */
  public function show(string $id)
  {
    $brand = Brand::find($id);

    if (!$brand) {
      return response()->json([
        'status' => false,
        'message' => 'Marca no encontrada.'
      ], 404); // 404 Not Found
    }

    return response()->json([
      'status' => true,
      'message' => 'Marca recuperada exitosamente.',
      'data' => $brand
    ], 200); // 200 OK
  }

  /**
   * Actualiza una marca existente (PUT /api/brands/{id}).
   */
  public function update(Request $request, string $id)
  {
    $brand = Brand::find($id);

    if (!$brand) {
      return response()->json([
        'status' => false,
        'message' => 'Marca no encontrada para actualizar.'
      ], 404); // 404 Not Found
    }

    // Reglas de validación para la ACTUALIZACIÓN:
    // Usamos 'sometimes' para permitir actualizaciones parciales.
    $validator = Validator::make($request->all(), [
      'name' => 'sometimes|string|max:255|unique:brands,name,' . $id,
    ]);

    // Si falla la validación, devuelve 422
    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Error de validación al actualizar la marca.',
        'errors' => $validator->errors()
      ], 422);
    }

    // Actualizar la marca
    $brand->update($request->all());

    // Devolver respuesta exitosa (código 200 OK)
    return response()->json([
      'status' => true,
      'message' => 'Marca actualizada exitosamente.',
      'data' => $brand
    ], 200);
  }

  /**
   * Elimina una marca (DELETE /api/brands/{id}).
   */
  public function destroy(string $id)
  {
    $brand = Brand::find($id);

    if (!$brand) {
      return response()->json([
        'status' => false,
        'message' => 'Marca no encontrada para eliminar.'
      ], 404); // 404 Not Found
    }

    $brand->delete();

    // Devolver respuesta sin contenido (código 204 No Content)
    return response()->json(null, 204);
  }
}
