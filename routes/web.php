<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminCategoryController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/signup', [AuthController::class, 'showSignup'])
        ->name('signup');

    Route::post('/signup', [AuthController::class, 'signup']);

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/admin/login', function () {
        return view('auth.adminlogin');
    })->name('admin.login');

    Route::post('/admin/login', [AuthController::class, 'login'])
        ->name('admin.login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/about', [HomeController::class, 'about'])
    ->name('about');

Route::get('/locations', [HomeController::class, 'locations'])
    ->name('locations');

Route::get('/catalog', [ProductController::class, 'index'])
    ->name('catalog.index');

Route::get('/catalog/{slug}', [ProductController::class, 'show'])
    ->name('catalog.show');

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

/*
|--------------------------------------------------------------------------
| USER AREA
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    Route::post('/cart/add', [CartController::class, 'add'])
        ->name('cart.add');

    Route::patch('/cart/{item}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::delete('/cart/{item}', [CartController::class, 'remove'])
        ->name('cart.remove');

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT & ORDERS
    |--------------------------------------------------------------------------
    */

    Route::match(['get', 'post'], '/checkout', [OrderController::class, 'checkout'])
        ->name('checkout');

    Route::post('/checkout/payment', [OrderController::class, 'payment'])
        ->name('checkout.payment');

    Route::post('/order/place', [OrderController::class, 'placeOrder'])
        ->name('order.place');

    Route::get('/order/confirmation', [OrderController::class, 'confirmation'])
        ->name('order.confirmation');

    Route::get('/order/myorders', [OrderController::class, 'myOrders'])
        ->name('order.myorders');

    Route::get('/order/{order}', [OrderController::class, 'show'])
        ->name('order.show');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | PRODUCTS
    |--------------------------------------------------------------------------
    */

    Route::resource('products', AdminProductController::class);

    /*
    |--------------------------------------------------------------------------
    | CATEGORIES
    |--------------------------------------------------------------------------
    */

    Route::resource('categories', AdminCategoryController::class);

    /*
    |--------------------------------------------------------------------------
    | CUSTOMERS
    |--------------------------------------------------------------------------
    */

    Route::get('/customers', [AdminCustomerController::class, 'index'])
        ->name('customers.index');

    Route::get('/customers/{id}', [AdminCustomerController::class, 'show'])
        ->name('customers.show');

    Route::patch('/customers/{user}/toggle-status', [AdminCustomerController::class, 'toggleStatus'])
        ->name('customers.toggle-status');

    /*
    |--------------------------------------------------------------------------
    | ORDERS
    |--------------------------------------------------------------------------
    */

    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])
        ->name('orders.show');

    Route::patch('/orders/{order}', [AdminOrderController::class, 'updateStatus'])
        ->name('orders.update');

    Route::patch('/orders/{order}/payment', [AdminOrderController::class, 'updatePayment'])
        ->name('orders.updatePayment');
});