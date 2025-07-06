<?php

namespace App\Application\AddToCart;

use App\Domain\AddToCart\AddToCart;
use App\Domain\AddToCart\AddToCartRepository;


class RegisterAddToCart
{
    public function __construct(private AddToCartRepository $add_to_cart_repository)
    {
        return $this->add_to_cart_repository = $add_to_cart_repository;
    }

    public function create(
        string $user_id,
        int $product_id,
        string $name,
        string $category,
        int $price,
        int $stock,
        int $quantity,
        string $description,
        string $image,
    ) {
        $new_add_to_cart = new AddToCart(
            $user_id,
            $product_id,
            $name,
            $category,
            $price,
            $stock,
            $quantity,
            $description,
            $image,
        );

        $this->add_to_cart_repository->register($new_add_to_cart);
    }
}
