<?php

namespace App\Domain\Order;

class Order
{
    public function __construct(
        private int $product_id,
        private string $user_id,
        private string $product_name,
        public float $price,
        public int $quantity,
        public float $total_price,
        public string $image,
        public string $status
    ) {
        $this->product_id = $product_id;
        $this->user_id = $user_id;
        $this->product_name = $product_name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->total_price = $total_price;
        $this->image = $image;
        $this->status = $status;
    }


    public function getProductID(): int
    {
        return $this->product_id;
    }

    public function getUserID(): string
    {
        return $this->user_id;
    }

    public function getProductName(): string
    {
        return $this->product_name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getTotalPrice(): float
    {
        return $this->total_price;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
