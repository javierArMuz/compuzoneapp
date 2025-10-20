<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use Exception;

class CheckoutController extends Controller
{
  /**
   * Simula el proceso de pago, creando la orden y disminuyendo el stock.
   */
  public function processCheckout(Request $request)
  {
    $cartItems = Session::get('cart', []);

    if (empty($cartItems)) {
      return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío y no se puede procesar el pago.');
    }

    DB::beginTransaction();

    try {
      $productsToUpdate = [];
      $totalAmount = 0;

      // Usamos un ID de orden temporal/simulado para el ejemplo
      $orderId = 'ORD-' . time() . rand(100, 999);
      $purchasedItems = [];

      // 3. Verificación Final de Stock y Disminución
      foreach ($cartItems as $productId => $item) {
        $product = Product::lockForUpdate()->find($productId);

        if (!$product) {
          throw new Exception("El producto con ID {$productId} ya no existe.");
        }

        $requestedQuantity = $item['quantity'];

        if ($product->stock < $requestedQuantity) {
          DB::rollBack();
          return redirect()->route('cart.index')->with('error', "Lo sentimos, solo quedan {$product->stock} unidades de '{$product->name}'. Por favor, ajusta la cantidad.");
        }

        // Disminuir Stock
        $product->stock -= $requestedQuantity;
        $productsToUpdate[] = $product;
        $itemTotal = $item['price'] * $requestedQuantity;
        $totalAmount += $itemTotal;

        // Almacenar detalles del ítem para la vista de confirmación
        $purchasedItems[] = [
          'name' => $product->name,
          'quantity' => $requestedQuantity,
          'price' => $item['price'],
          'subtotal' => $itemTotal,
          'image_url' => $item['image_url'] ?? 'placeholder',
        ];
      }

      // 4. Guardar los cambios de stock en la base de datos
      foreach ($productsToUpdate as $product) {
        $product->save();
      }

      // 5. Limpiar el Carrito
      Session::forget('cart');

      // 6. Confirmar la transacción
      DB::commit();

      // 7. Redirección de éxito a la página de confirmación, pasando los detalles.
      return redirect()->route('order.confirmation', $orderId)
        ->with([
          'success' => "🎉 ¡Compra exitosa! Tu pedido ha sido confirmado.",
          'order_id' => $orderId,
          'total_amount' => $totalAmount,
          'purchased_items' => $purchasedItems,
        ]);
    } catch (Exception $e) {
      DB::rollBack();
      return redirect()->route('cart.index')->with('error', 'Ocurrió un error al procesar el pago: ' . $e->getMessage());
    }
  }

  /**
   * Muestra la página de confirmación de la orden.
   */
  public function showConfirmation($orderId)
  {
    // Recuperar los datos del pedido de la sesión flash
    $success = Session::get('success');
    $totalAmount = Session::get('total_amount');
    $purchasedItems = Session::get('purchased_items', []);

    // Si los datos esenciales no están, redirigir al home
    if (!$success || !$totalAmount) {
      return redirect()->route('shop.index')->with('error', 'No se encontraron detalles de la orden reciente.');
    }

    return view('user.order.order_confirmation', [
      'orderId' => $orderId,
      'totalAmount' => $totalAmount,
      'purchasedItems' => $purchasedItems,
    ]);
  }
}
