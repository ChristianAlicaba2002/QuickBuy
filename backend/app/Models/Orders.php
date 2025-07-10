<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = "order";
    protected $primaryKey = "order_id";
    protected $fillable = [
        'order_id',
        'product_id',
        'user_id',
        'product_name',
        'price',
        'quantity',
        'total_price',
        'image',
        'status'
    ];
}
