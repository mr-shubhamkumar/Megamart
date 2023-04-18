<?php

use App\Http\Controllers\AccountController as AccountControllerAlias;
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
    Route::post('/forgot','forgot')->name('forgot');
    Route::match(['GET','POST'],'/reset','reset')->name('reset');
});

//Frontend Page Account
Route::controller(AccountControllerAlias::class)->group(function (){

    Route::prefix('account')->group(function (){
        Route::get('address','newAddress')->name('address.create');
        Route::post('address','newAddress')->name('address.store');

        Route::get('address/{id}','editAddress')->name('address.edit');
        Route::put('address/{id}','editAddress')->name('address.update');
    });

    Route::get('/account', 'index')->name('account.index');
    Route::post('/account', 'index')->name('account.index');

});


//Route::view('/account', 'account')->name('account');
Route::view('/products', 'products')->name('products');
Route::view('/cart', 'cart')->name('cart');
Route::view('/wishlist', 'wishlist')->name('wishlist');
