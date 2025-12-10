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

    // 2. Determinar la cantidad a agregar (por defecto 1, si no se envía)
    // Usamos 'quantity' como clave.
    $quantityToAdd = (int) $request->input('quantity', 1);

    // 3. Obtener la cantidad actual del producto en el carrito (si ya existe)
    $currentQtyInCart = $cart[$product->id]['quantity'] ?? 0;

    // 4. Calcular la cantidad total que habría después de la adición
    $newTotalQty = $currentQtyInCart + $quantityToAdd;

    // =========================================================================
    // 5. VALIDACIÓN CLAVE: Comparar la nueva cantidad total con el stock disponible
    // =========================================================================
    if ($newTotalQty > $product->stock) {

      // Determinar cuántas unidades se pueden añadir realmente
      $availableToAdd = $product->stock - $currentQtyInCart;

      // Si no se puede añadir ni una unidad, mostrar un mensaje más específico
      if ($availableToAdd <= 0) {
        $message = "El producto '{$product->name}' ya está agotado o has alcanzado el límite de stock en tu carrito ({$product->stock} unidades).";
      } else {
        $message = "Solo puedes agregar **{$availableToAdd}** unidad(es) más de '{$product->name}'. Actualmente tienes {$currentQtyInCart} y el stock total es {$product->stock}.";
      }

      // Redirigir de vuelta con el mensaje de error
      return redirect()->back()->with('error', $message);
    }

    // =========================================================================
    // 6. Si la validación pasa, proceder con la lógica para añadir/actualizar el carrito
    // =========================================================================

    // A. El producto ya existe en el carrito
    if (isset($cart[$product->id])) {
      // El producto ya está, incrementamos la cantidad (usando $newTotalQty calculado)
      $cart[$product->id]['quantity'] = $newTotalQty;
    } else {
      // B. El producto es nuevo, lo agregamos al carrito
      $cart[$product->id] = [
        'id'             => $product->id,
        'name'           => $product->name,
        'price'          => $product->price,
        'image_url'      => $product->image_url ?? 'https://placeholder.com/100x100/cccccc/333333?text=Sin+Imagen',
        'quantity'       => $newTotalQty, // Usamos la cantidad total ($newTotalQty)
        // Opcionalmente carga las relaciones para mostrar en la vista
        'stock'          => $product->stock,
        'brand_name'     => $product->brand_name ?? 'N/A',
        'category_name'  => $product->category_name ?? 'N/A',
      ];
    }

    // 7. Volver a guardar el carrito en la sesión
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
