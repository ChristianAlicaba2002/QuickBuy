<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddToCart extends Model
{
    protected $table = "add_to_carts";
    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'category',
        'price',
        'stock',
        'quantity',
        'description',
        'image',
    ];
}
