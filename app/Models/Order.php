<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'order_number',
    'total_amount',
    'status',
  ];

  /**
   * Una orden pertenece a un usuario.
   */
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  /**
   * Una orden tiene muchos ítems (detalles).
   */
  public function items()
  {
    return $this->hasMany(OrderItem::class);
  }
}
