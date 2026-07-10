<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\Admin\ProductController as AdminProductController;

Route::prefix('v1')->group(function () {

    // ========== PUBLIC ROUTES ==========
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::get('/categories', [ProductController::class, 'categories']);

    // ========== PROTECTED ROUTES (Auth Required) ==========
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);

        // Cart
        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart/items', [CartController::class, 'add']);
        Route::put('/cart/items/{cartItem}', [CartController::class, 'update']);
        Route::delete('/cart/items/{cartItem}', [CartController::class, 'remove']);

        // Orders
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders', [OrderController::class, 'index']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);

        // ========== ADMIN ROUTES (Role=admin) ==========
        Route::middleware('admin')->prefix('admin')->group(function () {
            Route::get('/products', [AdminProductController::class, 'index']);
            Route::post('/products', [AdminProductController::class, 'store']);
            Route::put('/products/{product}', [AdminProductController::class, 'update']);
            Route::delete('/products/{product}', [AdminProductController::class, 'destroy']);
        });
    });
});