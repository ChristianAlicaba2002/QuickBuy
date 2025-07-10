<?php

namespace App\Domain\Order;

interface OrderRepository
{
    public function create(Order $order);
}