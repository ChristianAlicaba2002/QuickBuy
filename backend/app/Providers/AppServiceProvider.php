<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Product\ProductRepository;
use App\Infrastructure\Eloquent\Product\EloquentProductRepository;
use App\Domain\AddToCart\AddToCartRepository;
use App\Infrastructure\Eloquent\AddToCart\EloquentAddToCartRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepository::class , EloquentProductRepository::class);
        $this->app->bind(AddToCartRepository::class , EloquentAddToCartRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
