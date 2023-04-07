<?php
use App\Http\Controllers\Dpanel\CategoryController;
use App\Http\Controllers\Dpanel\ProductController;
use App\Http\Controllers\Dpanel\BrandController;
use App\Http\Controllers\Dpanel\ColorController;
use App\Http\Controllers\Dpanel\SizeController;
use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Dpanel')->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/logout', [\DD4You\Dpanel\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::resource('global-settings', \DD4You\Dpanel\Http\Controllers\GlobalSettingController::class)->only('index', 'store');


    //AdminController
    Route::resource('product', ProductController::class)->names('product');
    Route::resource('category', CategoryController::class)->names('category')->only('index','store','update');
    Route::resource('brand', BrandController::class)->names('brand')->only('index','store','update');
    Route::resource('color', ColorController::class)->names('color')->only('index','store','update');
    Route::resource('size', SizeController::class)->names('size')->only('index','store','update');

});
