<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $products = Product::with([
            'image','variant'=>function($q){
            $q->with('color','size');
            }
        ])->latest()->limit(12)->get();
//        return $products;
        return view('welcome',compact('products'));
    }


    public function productDetails($slug){
        return view('product_details');
    }
}
