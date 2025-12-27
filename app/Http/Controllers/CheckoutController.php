<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; // Importación necesaria para obtener el ID del usuario
use App\Models\Product;
use App\Models\Order; // Modelo de Orden
use App\Models\OrderItem; // Modelo de Ítem de Orden
use Exception;

class CheckoutController extends Controller
{
  /**
   * Simula y procesa el pago, guarda el pedido y disminuye el stock.
   */
  public function processCheckout(Request $request)
  {
    // VERIFICACIÓN: El usuario debe estar autenticado para guardar una orden
    if (!Auth::check()) {
      return redirect()->route('login')->with('error', 'Debes iniciar sesión para completar la compra.');
    }

    $cartItems = Session::get('cart', []);

    if (empty($cartItems)) {
      return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío y no se puede procesar el pago.');
    }

    DB::beginTransaction();

    try {
      $totalAmount = 0;
      $orderItemsData = [];

      // 1. Pre-validación de stock y cálculo del total
      foreach ($cartItems as $productId => $item) {
        // Bloqueamos el producto en la base de datos para evitar condiciones de carrera (dos compras al mismo tiempo)
        $product = Product::lockForUpdate()->find($productId);

        if (!$product) {
          throw new Exception("El producto con ID {$productId} ya no existe.");
        }

        $requestedQuantity = $item['quantity'];

        if ($product->stock < $requestedQuantity) {
          DB::rollBack();
          return redirect()->route('cart.index')->with('error', "Lo sentimos, solo quedan {$product->stock} unidades de '{$product->name}'. Por favor, ajusta la cantidad.");
        }

        $itemTotal = $item['price'] * $requestedQuantity;
        $totalAmount += $itemTotal;

        // Preparar datos para el registro de OrderItem
        $orderItemsData[] = [
          'product_id' => $productId,
          'quantity' => $requestedQuantity,
          'price' => $item['price'],
          'product_name' => $product->name,
          'product_image_url' => $item['image_url'] ?? null,
        ];
      }

      // 2. Creación del registro principal de la Orden
      $order = Order::create([
        'user_id' => Auth::id(),
        'order_number' => 'ORD-' . time() . Auth::id(), // Generación de un número de orden simple y único
        'total_amount' => $totalAmount,
        'status' => 'pending',
      ]);

      // 3. Creación de los Ítems de la Orden y Disminución del Stock
      foreach ($orderItemsData as $itemData) {
        // A. Guardar el Item de la Orden (detalle del pedido)
        $order->items()->create($itemData);

        // B. Disminuir Stock del producto
        $product = Product::find($itemData['product_id']);
        $product->stock -= $itemData['quantity'];
        $product->save();
      }

      // 4. Limpiar el Carrito
      Session::forget('cart');

      // 5. Confirmar la transacción: si llegamos aquí, todo fue exitoso
      DB::commit();

      // 6. Redirección de éxito a la página de confirmación con el número de pedido
      return redirect()->route('order.confirmation', $order->order_number)
        ->with('success', "🎉 ¡Compra exitosa! Tu pedido ha sido confirmado.");
    } catch (Exception $e) {
      // Si algo falla (producto no encontrado, error de DB, etc.), se revierte todo
      DB::rollBack();
      return redirect()->route('cart.index')->with('error', 'Ocurrió un error al procesar el pago: ' . $e->getMessage());
    }
  }

  /**
   * Muestra la página de confirmación de la orden, obteniendo los datos de la DB.
   * @param string|null $orderNumber El número de orden
   */
  public function showConfirmation($orderNumber = null)
  {
    // 1. Verificar si hay un número de orden
    if (!$orderNumber) {
      return redirect()->route('shop.index')->with('error', 'Enlace de confirmación inválido.');
    }

    // 2. Buscar la orden en la base de datos
    $order = Order::where('order_number', $orderNumber)
      ->with('items') // Carga los ítems relacionados para el detalle
      ->where('user_id', Auth::id()) // Solo permite ver la orden al dueño (Seguridad)
      ->first();

    // 3. Verificar si la orden existe y si el usuario tiene permiso
    if (!$order) {
      return redirect()->route('shop.index')->with('error', 'Orden no encontrada o no tienes permisos para verla.');
    }

    // 4. Pasar el objeto de la orden a la vista
    return view('user.order.order_confirmation', [
      'order' => $order,
    ]);
  }
}
