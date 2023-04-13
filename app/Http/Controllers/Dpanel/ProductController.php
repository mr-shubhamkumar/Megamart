<?php

namespace App\Http\Controllers\Dpanel;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\ProductImage;
use App\Models\Size;
use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'color_id'=>'required|array|min:1',
            'size_id'=>'required|array|min:1',
            'mrp'=>'required|array|min:1',
            'selling_price'=>'required|array|min:1',
            'stock'=>'required|array|min:1',
            'images.*'=> 'mimes:jpg,jpeg,png'

        ]);
        // Store Product
        $product = new Product;
        $product->category_id = $req->category_id;
        $product->brand_id = $req->brand_id;
        $product->title = $req->title;
        $product->description = $req->description;
        $product->slug = Str::slug($req->title);
        $product->save();

        //Store Variant
        $colors = $req->color_id;
        foreach ($colors as $key=> $color_id){
            $product_id = $product->id;
            $size_id = $req->size_id[$key];
            $sku = 'FKP'. $product_id.'C'.$color_id.'S'.$size_id; #FKP1C2S1 where P=Product, C=Color and S=Size

            $variant = new  Variant;
            $variant->sku = $sku;
            $variant->product_id = $product_id;
            $variant->color_id = $color_id;
            $variant->size_id = $size_id;
            $variant->mrp = $req->mrp[$key];
            $variant->selling_price = $req->selling_price[$key];
            $variant->stock = $req->stock[$key];
            $variant->save();
        }

        foreach ($req->images as $image){
            $productImage = new ProductImage;
            $productImage->product_id = $product->id;
            $productImage->path = $image->store('media','public');
            $productImage->save();
        }

        return redirect()->route('dpanel.product.index')->with('success','New Products added successfully');
    }



    public function edit($id){
        $data =  Product::with('variant','image')->find($id);

        abort_if(!$data, 404);

        $brands = Brand::where("is_active",true)->get();
        $categories = Category::where("is_active",true)->get();
        $color = Color::where("is_active",true)->get();
        $size = Size::where("is_active",true)->get();
//        return $data;
        return view('dpanel.product.edit',compact('brands','categories','color','size','data'));
    }




    public function update(Request $req , $id)
    {
        $req->validate([
            'category_id'=>'required',
            'brand_id'=>'required',
            'title'=> 'required|max:255|unique:products,title,'.$id,
            'description'=>'required',
            'color_id'=>'required|array|min:1',
            'size_id'=>'required|array|min:1',
            'mrp'=>'required|array|min:1',
            'selling_price'=>'required|array|min:1',
            'stock'=>'required|array|min:1',
            'images.*'=> 'mimes:jpg,jpeg,png'

        ]);
        // Store Product
        $product =  Product::find($id);
        $product->category_id = $req->category_id;
        $product->brand_id = $req->brand_id;
        $product->title = $req->title;
        $product->description = $req->description;
        $product->slug = Str::slug($req->title);
        $product->save();

        //Store Variant
        $colors = $req->color_id;
        foreach ($colors as $key=> $color_id){
            $product_id = $product->id;
            $size_id = $req->size_id[$key];
            $sku = 'FKP'. $product_id.'C'.$color_id.'S'.$size_id; #FKP1C2S1 where P=Product, C=Color and S=Size

            if (isset($req->variant_ids[$key])){

            $variant =   Variant::find($req->variant_ids[$key]);
            }else{
                $variant = new  Variant;
            }
            $variant->sku = $sku;
            $variant->product_id = $product_id;
            $variant->color_id = $color_id;
            $variant->size_id = $size_id;
            $variant->mrp = $req->mrp[$key];
            $variant->selling_price = $req->selling_price[$key];
            $variant->stock = $req->stock[$key];
            $variant->save();
        }

        foreach ($req->images as $key=>$image){

            if (isset($req->image_ids[$key])){
                $productImage =  ProductImage::find($req->image_ids[$key]);
            Storage::disk('public')->delete($productImage->path);
                $productImage->path = $image->store('media','public');
                $productImage->save();

            }else{
                $productImage = new ProductImage;
                $productImage->product_id = $product->id;
                $productImage->path = $image->store('media','public');
                $productImage->save();
            }

        }

        return redirect()->route('dpanel.product.index')->with('success','New Products added successfully');
    }

}






