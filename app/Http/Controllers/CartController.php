<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
  /**
   * Muestra el contenido del carrito de compras.
   * Los datos del carrito se cargan desde la Sesión.
   */
  public function index()
  {
    // Obtiene el carrito de la sesión. Si no existe, devuelve un array vacío.
    $cartItems = Session::get('cart', []);

    // Inicializa el subtotal en 0
    $subtotal = 0;

    // Calcula el subtotal total del carrito
    foreach ($cartItems as $item) {
      $subtotal += $item['price'] * $item['quantity'];
    }

    return view('user.cart.index', compact('cartItems', 'subtotal'));
  }

  /**
   * Agrega un producto al carrito o incrementa su cantidad.
   */
  public function add(Product $product, Request $request)
  {
    // 1. Obtener el carrito actual de la sesión
    $cart = Session::get('cart', []);

    // Determinar la cantidad a agregar (por defecto 1, si no se envía)
    $quantity = $request->input('quantity', 1);

    // 2. Verificar si el producto ya existe en el carrito
    if (isset($cart[$product->id])) {
      // El producto ya está, incrementamos la cantidad
      $cart[$product->id]['quantity'] += $quantity;
    } else {
      // El producto es nuevo, lo agregamos al carrito
      $cart[$product->id] = [
        'id' => $product->id,
        'name' => $product->name,
        'price' => $product->price,
        // Si usas imágenes, puedes agregar la URL aquí
        'image_url' => $product->image_url ?? 'https://placehold.co/100x100/cccccc/333333?text=Sin+Imagen',
        'quantity' => $quantity,
        // Opcionalmente carga las relaciones para mostrar en la vista
        'brand_name' => $product->brand->name ?? 'N/A',
        'category_name' => $product->category->name ?? 'N/A',
      ];
    }

    // 3. Volver a guardar el carrito en la sesión
    Session::put('cart', $cart);

    // Redirigir de vuelta al producto con un mensaje de éxito
    return redirect()->back()->with('success', "¡'{$product->name}' agregado al carrito!");
  }

  /**
   * Actualiza la cantidad de un producto específico en el carrito.
   */
  public function update(Request $request, Product $product)
  {
    $cart = Session::get('cart', []);
    $newQuantity = (int)$request->input('quantity');

    if (isset($cart[$product->id])) {
      if ($newQuantity > 0) {
        $cart[$product->id]['quantity'] = $newQuantity;
        $message = "Cantidad de '{$product->name}' actualizada.";
      } else {
        // Si la cantidad es 0, lo eliminamos
        unset($cart[$product->id]);
        $message = "Producto '{$product->name}' eliminado del carrito.";
      }

      Session::put('cart', $cart);
      return redirect()->route('cart.index')->with('success', $message);
    }

    return redirect()->route('cart.index')->with('error', 'Producto no encontrado en el carrito.');
  }

  /**
   * Elimina un producto específico del carrito.
   */
  public function remove(Product $product)
  {
    $cart = Session::get('cart', []);

    if (isset($cart[$product->id])) {
      unset($cart[$product->id]);
      Session::put('cart', $cart);

      return redirect()->route('cart.index')->with('success', "Producto '{$product->name}' eliminado del carrito.");
    }

    return redirect()->route('cart.index')->with('error', 'El producto ya había sido eliminado.');
  }
}
