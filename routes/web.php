<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;



Route::controller(HomeController::class)->group(function (){
    Route::get('/','index')->name('landing_page');
    Route::get('/pd/{slug}','productDetails')->name('product_details');
});
//Route::view('/pd/slug', 'product_details')->name('product_details');
Route::view('/products', 'products')->name('products');
Route::view('/cart', 'cart')->name('cart');
Route::view('/wishlist', 'wishlist')->name('wishlist');
Route::view('/account', 'account')->name('account');
