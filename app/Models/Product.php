<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
  use HasFactory;

  // Campos que se pueden asignar masivamente
  protected $fillable = [
    'name',
    'description',
    'brand_id',
    'model',
    'price',
    'stock',
    'category_id',
    'image_url',
    'is_active',
  ];

  // Relación con la marca
  public function brand()
  {
    return $this->belongsTo(Brand::class); // Un producto pertenece a una marca
  }

  // Relación con la categoría
  public function category()
  {
    return $this->belongsTo(Category::class); // Un producto pertenece a una categoría
  }
}
