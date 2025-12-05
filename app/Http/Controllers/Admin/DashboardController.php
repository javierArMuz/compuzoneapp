<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\User;
use App\Models\Order;

class DashboardController extends Controller
{
  public function index()
  {
    // Obtener los conteos de la base de datos
    $productCount = Product::count();
    $categoryCount = Category::count();
    $brandCount = Brand::count();
    $userCount = User::count();
    $orderCount = Order::count();

    // Generar la vista del dashboard pasando los datos
    $response = response()->view('admin.dashboard', [
      'productCount' => $productCount,
      'categoryCount' => $categoryCount,
      'brandCount' => $brandCount,
      'userCount' => $userCount,
      'orderCount' => $orderCount,
    ]);

    // Añade las cabeceras HTTP anti-caché directamente a la respuesta
    $response->header('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate')
      ->header('Pragma', 'no-cache')
      ->header('Expires', 'Sat, 26 Jul 1997 05:00:00 GMT');

    return $response;
  }
}
