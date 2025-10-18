<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function index()
  {
    // Obtiene todos los productos y los envía a la vista
    $products = Product::with(['category', 'brand'])->paginate(10);
    return view('admin.products.index', compact('products'));
  }

  public function create()
  {
    $categories = Category::all();
    $brands = Brand::all();
    return view('admin.products.form', [
      'product'    => new Product(),
      'categories' => $categories,
      'brands'     => $brands,
      'editing'    => false,
    ]);
  }

  public function store(Request $request)
  {
    // Valida los datos del formulario
    $validated = $request->validate([
      'name'        => 'required|string|max:100',
      'description' => 'nullable|string',
      'brand_id'    => 'required|exists:brands,id',
      'model'       => 'nullable|string|max:100',
      'price'       => 'required|numeric|min:0',
      'stock'       => 'required|integer|min:0',
      'category_id' => 'required|exists:categories,id',
      'image_url'   => 'nullable|url|max:255',
      'is_active'   => 'nullable|boolean',
    ]);

    // Si 'is_active' no viene en el request, asignamos 0
    $validated['is_active'] = $request->has('is_active') ? 1 : 0;

    // Crea un nuevo producto con los datos validados
    Product::create($validated);
    // Redirige con mensaje de éxito
    return redirect()->route('admin.products.index')->with('ok', 'Producto guardado con éxito');
  }

  // Muestra el formulario de edición para un producto específico.
  public function edit(Product $product)
  {
    $categories = Category::all(); // Obtiene todas las categorías disponibles
    $brands = Brand::all(); // Obtiene todas las marcas disponibles
    return view('admin.products.form', [
      'product'    => $product, // Producto actual a editar
      'categories' => $categories, // Lista de categorías para el select
      'brands'     => $brands, // Lista de marcas para el select
      'editing'    => true, // Bandera para indicar modo edición
    ]);
  }

  // Actualiza un producto
  public function update(Request $request, Product $product)
  {
    $validated = $request->validate([
      'name'        => 'required|string|min:1|max:100',
      'description' => 'nullable|string',
      'brand_id'    => 'required|exists:brands,id',
      'model'       => 'nullable|string|max:100',
      'price'       => 'required|numeric|min:0.01',
      'stock'       => 'required|integer|min:0',
      'category_id' => 'required|exists:categories,id',
      'image_url'   => 'nullable|url|max:255',
      'is_active'   => 'nullable|boolean',
    ]);

    // Igual que en store: si no viene 'is_active', lo ponemos en 0
    $validated['is_active'] = $request->has('is_active') ? 1 : 0;

    $product->update($validated);
    return redirect()->route('admin.products.index')->with('ok', 'Producto actualizado');
  }

  // Elimina un producto
  public function destroy(Product $product)
  {
    $product->delete();
    return back()->with('ok', 'Producto eliminado');
  }
}
