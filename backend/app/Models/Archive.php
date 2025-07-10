<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $table = 'archives';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_id',
        'name',
        'price',
        'stock',
        'description',
        'image'
    ];
}
