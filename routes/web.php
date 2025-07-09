<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;



Auth::routes();

// routes/web.php
Route::redirect('/', '/login');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// products
Route::resource('/products', ProductController::class);

// categories
Route::get('/category/{id}/products', [ProductController::class, 'productsByCategory'])->name('categories.products');




// View Cart Page (GET, no id)

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Add to Cart (POST, needs product id)
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');


//update cart item quantity (POST, needs product id)
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');



Route::resource('wishlists', WishlistController::class);
Route::post('/wishlist/{product}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
