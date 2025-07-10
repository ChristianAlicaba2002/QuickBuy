<?php

namespace App\Infrastructure\Eloquent\AddToCart;
use App\Domain\AddToCart\AddToCart;
use App\Models\AddToCart as AddToCartModel;
use App\Domain\AddToCart\AddToCartRepository;

class EloquentAddToCartRepository implements AddToCartRepository
{
    public function register(AddToCart $add_to_cart)
    {
        $AddToCartModel = AddToCartModel::find($add_to_cart->getProductId()) ?? new AddToCartModel();
        $AddToCartModel->user_id = $add_to_cart->getUserId();
        $AddToCartModel->product_id = $add_to_cart->getProductId();
        $AddToCartModel->name = $add_to_cart->getName();
        $AddToCartModel->category = $add_to_cart->getCategory();
        $AddToCartModel->price = $add_to_cart->getPrice();
        $AddToCartModel->stock = $add_to_cart->getStock();
        $AddToCartModel->quantity = $add_to_cart->getQuantity();
        $AddToCartModel->description = $add_to_cart->getDescription();
        $AddToCartModel->image = $add_to_cart->getImage();
        $AddToCartModel->save();
    }
}