<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
  use HasFactory;

  protected $fillable = [
    'order_id',
    'product_id',
    'quantity',
    'price',
    'product_name',
    'product_image_url',
  ];

  /**
   * Un ítem pertenece a una orden.
   */
  public function order()
  {
    return $this->belongsTo(Order::class);
  }

  /**
   * Un ítem (opcionalmente) se relaciona con el producto actual.
   */
  public function product()
  {
    return $this->belongsTo(Product::class);
  }
}
