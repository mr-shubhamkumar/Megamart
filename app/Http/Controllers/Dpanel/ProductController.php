<?php

namespace App\Http\Controllers\Dpanel;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::with('brand','category')->paginate(10);
        return view('dpanel.product.index',compact('data'));
    }


    public function create(){
        $brands = Brand::where("is_active",true)->get();
        $categories = Category::where("is_active",true)->get();
        return view('dpanel.product.create',compact('brands','categories'));
    }
}






