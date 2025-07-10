<?php

namespace App\Infrastructure\Eloquent\Product;
use App\Domain\Product\Product;
use App\Domain\Product\ProductRepository;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class EloquentProductRepository implements ProductRepository
{
    public function create(Product $product)
    {
        $productModel = Products::find($product->getProductId()) ?? new Products();
        $productModel->product_id = $product->getProductId();
        $productModel->name = $product->getName();
        $productModel->category = $product->getCategory();
        $productModel->price = $product->getPrice();
        $productModel->stock = $product->getStock();
        $productModel->description = $product->getDescription();
        $productModel->image = $product->getImage();
        $productModel->save();
    }

    public function update(Product $product)
    {
        $productModel = Products::find($product->getProductId()) ?? new Products();
        $productModel->product_id = $product->getProductId();
        $productModel->name = $product->getName();
        $productModel->category = $product->getCategory();
        $productModel->price = $product->getPrice();
        $productModel->stock = $product->getStock();
        $productModel->description = $product->getDescription();
        $productModel->image = $product->getImage();
        $productModel->save();
    }


    public function delete(int $product_id)
    {
        $product = Products::find($product_id);
         
        if(!$product_id)
        {
            throw ('Account not found');
        }
        
        DB::table('product')->where('product_id', $product_id)->delete();
    }
}