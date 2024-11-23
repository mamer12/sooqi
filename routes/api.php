<?php


use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Support\Facades\Route;

// API Resource Routes
Route::apiResource('products', ProductController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-item', OrderItemController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('categories', CategoryController::class);

