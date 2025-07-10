<?php

namespace App\Infrastructure\Eloquent\Order;
use App\Domain\Order\Order;
use App\Domain\Order\OrderRepository;
use App\Models\Orders;

class EloquentOrderRepository implements OrderRepository
{
    public function create(Order $order)
    {
        $OrderModel = Orders::find($order->getProductID()) ?? new Orders();
        $OrderModel->product_id = $order->getProductID();
        $OrderModel->user_id = $order->getUserID();
        $OrderModel->product_name = $order->getProductName();
        $OrderModel->price = $order->getPrice();
        $OrderModel->quantity = $order->getQuantity();
        $OrderModel->total_price = $order->getTotalPrice();
        $OrderModel->image = $order->getImage();
        $OrderModel->status = $order->getStatus();
        $OrderModel->save();
    }
}