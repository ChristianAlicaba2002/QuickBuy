<?php

namespace App\Domain\Product;

interface ProductRepository
{
    public function create(Product $product);
    public function update(Product $product);
    public function delete(int $product_id);
}