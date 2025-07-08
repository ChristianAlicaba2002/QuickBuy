<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application\Order\RegisterOrder;
use App\Models\AddToCart;
use App\Models\Products;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function __construct(private RegisterOrder $register_order)
    {
        return $this->register_order = $register_order;
    }

    public function userOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'user_id' => 'required|string',
            'product_name' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'total_price' => 'required|numeric',
            'image' => 'required|nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }

        $item = AddToCart::where('product_id', $request->product_id)
            ->where('user_id', $request->user_id)->first();

        if (!$item) {
            return response()->json([
                'status' => false,
                'message' => 'User ID and Product ID not found',
            ]);
        }

        $orderItem = $this->register_order->create(
            $request->product_id,
            $request->user_id,
            $request->product_name,
            $request->price,
            $request->quantity,
            $request->total_price,
            $request->image,
            'pending'
        );

        AddToCart::where('product_id', $item->product_id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Order successfully',
            'data' => $orderItem
        ]);
    }

    public function acceptTheUserOrder(Request $request, $order_id)
    {

    }
}
