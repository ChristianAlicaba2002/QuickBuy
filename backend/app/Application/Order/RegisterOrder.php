<?php

namespace App\Application\Order;

use App\Domain\Order\Order;
use App\Domain\Order\OrderRepository;

class RegisterOrder
{
    public function __construct(private OrderRepository $order_repository)
    {
        return $this->order_repository = $order_repository;
    }

    public function create(
        int $product_id,
        string $user_id,
        string $product_name,
        float $price,
        int $quantity,
        float $total_price,
        string $image,
        string $status
    ) {
        $new_order = new Order(
            $product_id,
            $user_id,
            $product_name,
            $price,
            $quantity,
            $total_price,
            $image,
            $status
        );

        $this->order_repository->create($new_order);
    }
}
