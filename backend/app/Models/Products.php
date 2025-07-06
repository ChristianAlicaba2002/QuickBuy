<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_id',
        'name',
        'category',
        'price',
        'stock',
        'description',
        'image'
    ];
}
