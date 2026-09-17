<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Support\Facades\Route;

// --- RUTE PUBLIK (Tanpa Login) ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/payment/callback', [PaymentController::class, 'callback']);

Route::prefix('public')->group(function () {
    Route::get('/produk', [ProductController::class, 'index']);
    Route::get('/produk/{id}', [ProductController::class, 'show']);
    Route::get('/kategori', [CategoryController::class, 'index']);
});

// --- RUTE YANG MEMERLUKAN AUTENTIKASI (Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {
    // Auth Profile
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Kategori (Admin/Auth)
    Route::get('/kategori', [CategoryController::class, 'index']);
    Route::post('/kategori', [CategoryController::class, 'store']);
    Route::put('/kategori/{id}', [CategoryController::class, 'update']);
    Route::delete('/kategori/{id}', [CategoryController::class, 'destroy']);

    // Cart / Keranjang
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);

    // Produk (Admin/Auth Management)
    Route::get('/produk', [ProductController::class, 'index']);
    Route::post('/produk', [ProductController::class, 'store']);
    Route::get('/produk/{id}', [ProductController::class, 'show']);
    Route::put('/produk/{id}', [ProductController::class, 'update']);
    Route::delete('/produk/{id}', [ProductController::class, 'destroy']);

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy']);

    // Pesanan / Order
    Route::get('/pesanan', [OrderController::class, 'index']);
    Route::post('/pesanan', [OrderController::class, 'store']);
    Route::get('/pesanan/{id}', [OrderController::class, 'show']);
});
