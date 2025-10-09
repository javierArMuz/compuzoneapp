<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{

  //  Muestra una lista de todos los productos (GET /api/products).
  //  Incluye las relaciones 'brand' y 'category'.

  public function index()
  {
    // Se cargan las relaciones para evitar el problema N+1
    $products = Product::with('brand', 'category')->get();

    return response()->json([
      'status' => true,
      'message' => 'Lista de productos recuperada exitosamente.',
      'data' => $products
    ], 200); // 200 OK
  }


  // Almacena un nuevo producto (POST /api/products).
  // Incluye validación de datos.

  public function store(Request $request)
  {
    // Reglas de validación para la creación de un producto (Todos los campos son obligatorios)
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255|unique:products,name',
      'description' => 'nullable|string',
      'price' => 'required|numeric|min:0',
      'stock' => 'required|integer|min:0',
      'brand_id' => 'required|exists:brands,id',
      'category_id' => 'required|exists:categories,id',
    ]);

    // Si falla la validación, devuelve 422 (Unprocessable Content) con los errores
    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Error de validación al crear el producto.',
        'errors' => $validator->errors()
      ], 422);
    }

    // Crear el producto
    $product = Product::create($request->all());

    // Devolver respuesta exitosa (código 201 Created)
    return response()->json([
      'status' => true,
      'message' => 'Producto creado exitosamente.',
      'data' => $product->load('brand', 'category') // Cargar relaciones en la respuesta
    ], 201);
  }


  // Muestra un producto específico (GET /api/products/{id}).

  public function show(string $id)
  {
    $product = Product::with('brand', 'category')->find($id);

    if (!$product) {
      return response()->json([
        'status' => false,
        'message' => 'Producto no encontrado.'
      ], 404); // 404 Not Found
    }

    return response()->json([
      'status' => true,
      'message' => 'Producto recuperado exitosamente.',
      'data' => $product
    ], 200); // 200 OK
  }


  //  Actualiza un producto existente (PUT /api/products/{id}).

  public function update(Request $request, string $id)
  {
    $product = Product::find($id);

    if (!$product) {
      return response()->json([
        'status' => false,
        'message' => 'Producto no encontrado para actualizar.'
      ], 404); // 404 Not Found
    }

    // Reglas de validación para la ACTUALIZACIÓN:
    // Usamos 'sometimes' en todos los campos para permitir actualizaciones parciales.
    // La regla 'sometimes' indica que el campo solo se validará si está presente en la solicitud.
    $validator = Validator::make($request->all(), [
      'name' => 'sometimes|string|max:255|unique:products,name,' . $id,
      'description' => 'sometimes|nullable|string',
      'price' => 'sometimes|numeric|min:0',
      'stock' => 'sometimes|integer|min:0',
      'brand_id' => 'sometimes|exists:brands,id',
      'category_id' => 'sometimes|exists:categories,id',
    ]);

    // Si falla la validación, devuelve 422
    if ($validator->fails()) {
      return response()->json([
        'status' => false,
        'message' => 'Error de validación al actualizar el producto.',
        'errors' => $validator->errors()
      ], 422);
    }

    // Actualizar el producto (solo se actualizan los campos presentes en $request->all())
    $product->update($request->all());

    // Devolver respuesta exitosa (código 200 OK)
    return response()->json([
      'status' => true,
      'message' => 'Producto actualizado exitosamente.',
      'data' => $product->load('brand', 'category')
    ], 200);
  }


  // Elimina un producto (DELETE /api/products/{id}).

  public function destroy(string $id)
  {
    $product = Product::find($id);

    if (!$product) {
      return response()->json([
        'status' => false,
        'message' => 'Producto no encontrado para eliminar.'
      ], 404); // 404 Not Found
    }

    $product->delete();

    // Devolver respuesta sin contenido (código 204 No Content)
    return response()->json(null, 204);
  }
}
