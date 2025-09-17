<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Campos que se pueden asignar masivamente
    protected $fillable = ['name'];
}
