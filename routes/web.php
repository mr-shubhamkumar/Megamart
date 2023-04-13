<?php

use App\Http\Controllers\AuthContoller;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\HomeController;



Route::controller(HomeController::class)->group(function (){
    Route::get('/','index')->name('landing_page');
    Route::get('/pd/{slug}','productDetails')->name('product_details');
});

//Authentication
Route::controller(AuthContoller::class)->group(function (){
    Route::get('/logout','logout')->name('logout');
    Route::post('/login','login')->name('login');
    Route::post('/register','register')->name('register');
});



Route::view('/products', 'products')->name('products');
Route::view('/cart', 'cart')->name('cart');
Route::view('/wishlist', 'wishlist')->name('wishlist');
Route::view('/account', 'account')->name('account');
