<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// Product routes
Route::post('/products', [ProductController::class, 'createProduct']);
Route::get('/products/{id}', [ProductController::class, 'getProduct']);
Route::put('/products/{id}', [ProductController::class, 'updateProduct']);
Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);

// User routes
Route::post('/users/register', [UserController::class, 'registerUser']);
Route::post('/users/login', [UserController::class, 'loginUser']);
Route::get('/users/{id}', [UserController::class, 'getUser']);
Route::put('/users/{id}', [UserController::class, 'updateUser']);

// Comment routes
Route::post('/comments', [CommentController::class, 'addComment']);
Route::get('/comments/{productId}', [CommentController::class, 'getComments']);
Route::delete('/comments/{id}', [CommentController::class, 'deleteComment']);

// Cart routes
Route::post('/cart', [CartController::class, 'addToCart']);
Route::get('/cart/{userId}', [CartController::class, 'getCart']);
Route::put('/cart/{userId}', [CartController::class, 'updateCart']);
Route::delete('/cart/{userId}/{itemId}', [CartController::class, 'removeFromCart']);

// Order routes
Route::post('/orders', [OrderController::class, 'createOrder']);
Route::get('/orders/{id}', [OrderController::class, 'getOrder']);
Route::delete('/orders/{id}', [OrderController::class, 'cancelOrder']);