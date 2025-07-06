<?php

namespace App\Application\Product;
use App\Domain\Product\Product;
use App\Domain\Product\ProductRepository;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\error;

class RegisterProduct
{
    public function __construct(private ProductRepository $productRepository)
    {
        return $this->productRepository = $productRepository;
    }

    public function create(
        int $product_id,
        string $name,
        string $category,
        int $price,
        int $stock,
        string $description,
        string $image
    )
    {
        $new_product = new Product(
            $product_id,
            $name,
            $category,
            $price,
            $stock,
            $description,
            $image
        );

        $this->productRepository->create($new_product);
    
    }

    public function update(
        int $product_id,
        string $name,
        string $category,
        int $price,
        int $stock,
        string $description,
        string $image
    )
    {
        $update_product = new Product(
            $product_id,
            $name,
            $category,
            $price,
            $stock,
            $description,
            $image
        );

        $this->productRepository->update($update_product);
    }   

    public function delete(int $product_id)
    {
        $product = Products::find($product_id);

        if(!$product_id)
        {
            throw error('Account not found');
        }

        $this->productRepository->delete($product);
    }
}