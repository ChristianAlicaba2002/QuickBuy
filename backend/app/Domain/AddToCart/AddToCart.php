<?php

namespace App\Domain\AddToCart;

class AddToCart
{
    public function __construct(
        private string $user_id,
        private int $product_id,
        public string $name,
        public string $category,
        public int $price,
        public int $stock,
        public int $quantity,
        public string $description,
        public string $image,
    ) {
        $this->user_id = $user_id;
        $this->product_id = $product_id;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->image = $image;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): string
    {
        return $this->image;
    }
}
