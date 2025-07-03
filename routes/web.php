<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// products
Route::resource('products', \App\Http\Controllers\ProductController::class);