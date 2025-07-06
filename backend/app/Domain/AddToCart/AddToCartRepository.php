<?php

namespace App\Domain\AddToCart;

interface AddToCartRepository
{
    public function register(AddToCart $add_to_cart);
}