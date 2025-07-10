<?php

namespace App\Http\Controllers\API;

use App\Models\Orders;
use App\Models\Products;
use App\Models\AddToCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Application\Order\RegisterOrder;
use App\Domain\Order\Order;
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

        Products::where('product_id', $request->product_id)
            ->where('stock', '>=', (int)$request->quantity)
            ->update(['stock' => DB::raw('stock - ' . (int)$request->quantity)]);

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
            'Pending'
        );

        AddToCart::where('product_id', $item->product_id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Order successfully',
            'data' => $orderItem
        ]);
    }

    public function acceptTheUserOrder($order_id)
    {
        $order = Orders::where('order_id', $order_id)->first();

        if (!$order) {
            return redirect()->route('order-pending')->with('error', 'Order not found');
        }

        $order->status = 'Accepted';
        $order->save();

        return redirect()->route('order-pending')->with('success', 'Order accept successfully');
    }
}
