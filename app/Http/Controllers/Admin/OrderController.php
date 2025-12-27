<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  // Listado de pedidos
  public function index()
  {
    $orders = Order::with('user')->latest()->paginate(10);
    return view('admin.orders.index', compact('orders'));
  }

  // Detalle del pedido
  public function show(Order $order)
  {
    // Cargamos los productos asociados al pedido
    $order->load('items.product', 'user');
    return view('admin.orders.show', compact('order'));
  }

  // Actualizar estado del pedido
  public function updateStatus(Request $request, Order $order)
  {
    $request->validate([
      'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
    ]);

    $order->update(['status' => $request->status]);

    return redirect()->back()->with('ok', 'Estado del pedido actualizado correctamente.');
  }
}
