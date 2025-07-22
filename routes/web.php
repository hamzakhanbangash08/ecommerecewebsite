<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;



Auth::routes();

// routes/web.php
Route::redirect('/', '/login');




Route::middleware(['auth'])->group(function () {

    Route::get('/adminpage', [AdminController::class, 'adminpage'])->name('adminpage');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    /////profile update
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
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


    // delete from cart
    Route::delete('/cart/{id}/destroy', [CartController::class, 'destroy'])->name('cart.destroy');



    Route::resource('wishlists', WishlistController::class);
    Route::post('/wishlist/{product}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // rating
    Route::post('/product/{id}/rate', [RatingController::class, 'store'])->name('ratings.store');

    ///
    Route::post('/ratings/{rating}/vote', [RatingController::class, 'vote'])->name('ratings.vote');


    // checkout route
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    Route::get('/test-mail', function () {
        Mail::raw('This is a test email from Laravel.', function ($message) {
            $message->to('you@example.com')
                ->subject('Test Mail');
        });

        return 'Test mail sent!';
    });
});
