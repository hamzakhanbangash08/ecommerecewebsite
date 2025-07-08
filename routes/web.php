<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});


// products
Route::resource('products', ProductController::class);

// categories
Route::get('/category/{id}/products', [ProductController::class, 'productsByCategory'])->name('categories.products');




// View Cart Page (GET, no id)

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Add to Cart (POST, needs product id)
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');

// 
// routes/web.php
Route::get('/clear-cart', function () {
    session()->forget('cart');
    return redirect()->back()->with('success', 'Cart cleared!');
});
