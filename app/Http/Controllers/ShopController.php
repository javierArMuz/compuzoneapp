<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
  /**
   * Muestra la galería de productos.
   * Implementa la lógica de búsqueda basada en el parámetro 'search' de la URL.
   * * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    // 1. Obtener el término de búsqueda de la URL (?search=...)
    $searchQuery = $request->input('search');

    // 2. Crear una consulta base para el modelo Product
    $productsQuery = Product::query();

    // 3. Aplicar el filtro de búsqueda si el término no está vacío
    if ($searchQuery) {

      // Usamos where y orWhere con la cláusula LIKE para buscar coincidencias
      // en el nombre Y en la descripción del producto.
      $productsQuery->where('name', 'like', '%' . $searchQuery . '%')
        ->orWhere('description', 'like', '%' . $searchQuery . '%');
    }

    // 4. Ejecutar la consulta. 
    // Es altamente recomendable usar paginate() para manejar grandes volúmenes de datos:
    // $products = $productsQuery->paginate(12);

    // Usaremos get() por simplicidad inicial:
    $products = $productsQuery->get();


    // 5. Retornar la vista 
    // e inyectar los productos y el término de búsqueda.
    return view('user.dashboard', [
      'products' => $products,
      'searchQuery' => $searchQuery, // Se envía para mantener el texto en el input de búsqueda
    ]);
  }

  /**
   * Muestra la vista de detalles de un producto específico.
   * Laravel automáticamente resuelve el ID de la URL en un objeto Product (Route Model Binding).
   * @param  \App\Models\Product  $product
   * @return \Illuminate\View\View
   */
  public function show(Product $product)
  {
    // El producto ya está cargado gracias al Route Model Binding.
    // Ahora solo necesitamos devolver una vista y pasarle el objeto $product.
    return view('user.products.show', [
      'product' => $product,
    ]);
  }
}
