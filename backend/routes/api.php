<?php

use App\Http\Controllers\API\AddToCartController;
use App\Http\Controllers\API\APIProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// User API
Route::post('users', [UserController::class, 'User']);


// Product API
Route::get('/storage/{imageName}', function ($imageName) {
    return response()->file(public_path('images/' . $imageName));
});
Route::get('/products', [APIProductController::class, 'allProducts']);
Route::get('/products/search', [APIProductController::class, 'searchProduct']);
Route::post('/addToCart/{id}', [AddToCartController::class, 'receivedUserAddToCart']);
Route::get('/userItemCart/{id}', [AddToCartController::class, 'getUserAddToCart']);
Route::get('/itemInCart', [AddToCartController::class, 'allItemInCart']);
Route::post('/userOrder', [OrderController::class, 'userOrder']);
