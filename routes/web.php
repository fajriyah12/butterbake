<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

// ===================== AUTH =====================
Route::middleware('guest')->group(function () {
    Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ===================== PUBLIC =====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/locations', [HomeController::class, 'locations'])->name('locations');

// Products — publik, siapa pun bisa lihat
Route::get('/catalog', [ProductController::class, 'index'])->name('catalog.index');
Route::get('/catalog/{slug}', [ProductController::class, 'show'])->name('catalog.show');

// Cart READ — publik (user bisa lihat keranjang tanpa login)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// ===================== AUTH REQUIRED =====================
Route::middleware('auth')->group(function () {

    // Cart WRITE — wajib login agar cart tersimpan ke user_id
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{item}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout & Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/payment', [OrderController::class, 'payment'])->name('checkout.payment');
    Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/order/confirmation', [OrderController::class, 'confirmation'])->name('order.confirmation');
    Route::get('/orders', [OrderController::class, 'myOrders'])->name('order.list');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});