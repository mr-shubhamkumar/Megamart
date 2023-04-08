<?php

namespace App\Http\Controllers\Dpanel;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $color = Color::where("is_active",true)->get();
        $size = Size::where("is_active",true)->get();
        return view('dpanel.product.create',compact('brands','categories','color','size'));
    }



    public function store(Request $req)
    {
        $req->validate([
            'category_id'=>'required',
            'brand_id'=>'required',
            'title'=> 'required|max:255|unique:products',
            'description'=>'required',

        ]);
        $product = new Product;
        $product->category_id = $req->category_id;
        $product->brand_id = $req->brand_id;
        $product->title = $req->title;
        $product->description = $req->description;
        $product->slug = Str::slug($req->title);

        $product->save();

        return redirect()->route('dpanel.brand.index')->with('success','New Products added successfully');
    }
}






