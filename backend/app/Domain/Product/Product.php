<?php

namespace App\Domain\Product;

class Product
{
    public function __construct(
        private int $product_id,
        public string $name,
        public string $category,
        public int $price,
        public int $stock,
        public string $description,
        public string $image
    ) {
        $this->product_id = $product_id;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
        $this->description = $description;
        $this->image = $image;
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
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getImage(): string
    {
        return $this->image;
    }
}
