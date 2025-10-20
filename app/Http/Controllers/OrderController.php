<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
  /**
   * Muestra la lista de todos los pedidos del usuario autenticado.
   */
  public function index()
  {
    // 1. Obtener el ID del usuario autenticado
    $userId = Auth::id();

    // 2. Consultar todos los pedidos del usuario
    // Usamos 'with('items')' para cargar los detalles del pedido (eager loading)
    // y 'orderBy' para mostrar los más recientes primero.
    $orders = Order::where('user_id', $userId)
      ->with('items')
      ->orderBy('created_at', 'desc')
      ->get();

    // 3. Pasar los pedidos a la vista
    return view('user.order.order_history', compact('orders'));
  }
}
