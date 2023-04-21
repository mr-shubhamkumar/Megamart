<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'image', 'variant' => function ($q) {
                $q->with('color', 'size');
            }
        ])
            ->withCount('image')
            ->havingRaw('image_count > 0')
            ->latest()->limit(12)->get();
//        return $products;
        return view('welcome', compact('products'));
    }


    public function productDetails(Request $request, $slug)
    {
        $filter[] = $request->c ?? null;
        $filter[] = $request->s ?? null;

        $product = Product::with([
            'image',
            'brand',
            'variant' => function ($q) use ($filter) {
                $color_id = $filter[0];
                $size_id = $filter[1];
                $q->when($color_id, function ($q2, $color_id) {
                    return $q2->where('color_id', $color_id);

                })->when($size_id, function ($q2, $size_id) {
                    return $q2->where('size_id', $size_id);

                })->with('color', 'size');
            }

        ])->where('slug', $slug)->first();


        abort_if(!$product, 404);


        $products = Product::with([
            'image',
            'variant' => function ($q) {
                $q->with('color', 'size');
            }
        ])
            ->withCount('image')
            ->havingRaw('image_count > 0')
            ->latest()->limit(12)->get();

//        return $product;
        return view('product_details', compact('products', 'product'));
    }

    public function products(Request $request)
    {
        $search = $request->k ?? null;

        $query = Product::query();
        #Search In Product Title and Description
        $query->when(
            $search,
            fn($q)
                =>$q->where('title','LIKE'.'%'.$search.'%')
                ->where('description','LIKE'.'%'.$search.'%')
        );

        #Filter By Color AND Size AND Price
        $query->whereHas('variant',function ($q) use ($request){
            $sizes = urldecode($request->size) ?? null;
            $_sizes = explode(',',$sizes);
            $q->when($sizes, fn($q2)=> $q2->whereIn('size_id',$_sizes));

            $colors = urldecode($request->color) ?? null;
            $_colors = explode(',',$colors);
            $q->when($colors, fn($q2)=> $q2->whereIn('color_id',$_colors));

            $price_min = $request->min ?? null;
            $q->when($price_min, fn($q2) => $q2->where('selling_price', '>=',$price_min));

            $price_max = $request->max ?? null;
            $q->when($price_max, fn($q2) => $q2->where('selling_price', '<=',$price_max));

        });

        #If Don't have image then not return itm
        $query->with('image','variant')
            ->withCount('image')
            ->havingRaw('image_count > 0');

        #Sort By Filter
        if (in_array($request->sb,['price_asc','price_desc'])){
            $query->with(['variant'=>fn($q)=> $q->orderBy('selling_price'
            ,substr($request->sb,6))]);
        }else{
            if ($request->sb == 'desc') $query->orderBy('update_at');
        };

        $products = $query->paginate(16);

        #Get colors than the product is available in
        $colors = Color::whereIn(
            'id',
            fn($q)=>$q->select('color_id')->from('variants')->distinct()->get()
        )->get(['id','name','code']);
        #Get sizes than the product is available in
        $sizes = Size::whereIn(
            'id',
            fn($q)=>$q->select('size_id')->from('variants')->distinct()->get()
        )->get(['id','name','code']);
        return view('products',compact('products','colors','sizes'));
    }
}

