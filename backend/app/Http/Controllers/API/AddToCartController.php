<?php

namespace App\Http\Controllers\API;

use App\Models\AddToCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Application\AddToCart\RegisterAddToCart;
use App\Models\Products;

class AddToCartController extends Controller
{
    public function __construct(private RegisterAddToCart $register_add_to_cart)
    {
        return $this->register_add_to_cart = $register_add_to_cart;
    }

    public function allItemInCart()
    {
        $item = AddToCart::all();

        return response()->json([
            'status' => true,
            'message' => 'all item in cart',
            'data' => $item
        ]);
    }

    public function getUserAddToCart(string $user_id)
    {
        $user = AddToCart::where('user_id', $user_id)->get();
        $allUserItem = $user->count();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'User item in cart retrieve successfully',
            'data' => $user,
            'count' => $allUserItem,
        ]);
    }

    public function receivedUserAddToCart(Request $request, int $product_id)
    {
        // Validate request first
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string',
            'product_id' => 'required|numeric',
            'name' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'quantity' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required', // Consider 'required|image' if expecting a file
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }

        // Check if product exists
        $product = Products::where('product_id', $request->product_id)->first();
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        // Check if item already in cart
        $existingCartItem = AddToCart::where('product_id', $request->product_id)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingCartItem) {
            $existingCartItem->quantity += $request->quantity;
            $existingCartItem->save();

            return response()->json([
                'status' => true,
                'message' => 'Cart item quantity updated',
                'data' => $existingCartItem
            ], 200);
        }

        // Create new cart item
        $item = $this->register_add_to_cart->create(
            $request->user_id,
            $request->product_id,
            $request->name,
            $request->category,
            $request->price,
            $request->stock,
            $request->quantity,
            $request->description,
            $request->image
        );

        return response()->json([
            'status' => true,
            'message' => 'Item added in cart successfully',
            'data' => $item
        ], 201);
    }
}
