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

    public function searchProduct(Request $request)
    {
        $name = $request->query('search');
        
        $products = Products::where('name', 'LIKE', '%' . $name . '%')->get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No products found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => $products
        ], 200);
    }
}
