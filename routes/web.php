<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthContoller;
use \App\Http\Controllers\HomeController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AccountController as AccountControllerAlias;



Route::controller(HomeController::class)->group(function (){
    Route::get('/','index')->name('landing_page');
    Route::get('/pd/{slug}','productDetails')->name('product_detail');
    Route::get('/products','products')->name('products');
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
        Route::get('orders/{id}', 'showOrder')->name('order.show');
        Route::get('address','newAddress')->name('address.create');
        Route::post('address','newAddress')->name('address.store');

        Route::get('address/{id}','editAddress')->name('address.edit');
        Route::put('address/{id}','editAddress')->name('address.update');
    });

    Route::get('/account', 'index')->name('account.index');
    Route::post('/account', 'index')->name('account.index');

});

Route::controller(\App\Http\Controllers\CartController::class)->group(function (){
    Route::get('/cart','index')->name('cart');
    Route::get('/cart/products','apiCartProducts');
    Route::post('/cart/coupon','apiApplyCoupon');

    #Peyment Route
    Route::post('/payment/init','initPeyment')->name('payment.init');
    Route::post('/payment/failed','peymentFailed')->name('payment.failed');
    Route::post('/payment/verify/{id}','peymentVerify');
});

Route::controller(WishlistController::class)->group(function () {
    Route::get('/wishlist', 'index')->name('wishlist');
    Route::post('/wishlist/{id}', 'toggle');
});

Route::get('/install',function (){
   \Illuminate\Support\Facades\Artisan::call('key:generate');
   \Illuminate\Support\Facades\Artisan::call('optimize:clear');
   \Illuminate\Support\Facades\Artisan::call('storage:link');
   return 'success';
});


