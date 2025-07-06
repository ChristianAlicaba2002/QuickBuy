<?php

namespace App\Http\Controllers\API;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class APIProductController extends Controller
{
    
    public function allProducts()
    {
        $products = Products::all();

        return response()->json([
            'status' => true,
            'message' => 'Product retrieve successfully',
            'data' => $products
        ], 200);
    }

    // public function searchProduct($category)
    // {
    //     $product = Products::where('category' , $category);
    //     if(!$product)
    //     {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Item not found'
    //         ],404);
    //     }
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Item retrieve successfully',
    //         'data' => $product
    //     ],200);
    // }
}
