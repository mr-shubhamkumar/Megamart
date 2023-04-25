<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\UserAddress;
use App\Models\Variant;
use Carbon\Carbon;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function index(){
        $address = [];
        if (auth()->check()){
            $address = UserAddress::where('user_id',auth()->user()->id)->get();
        }
//        return  $address;
        return view('cart',compact('address'));
    }

    public function apiCartProducts(Request $request ){
        $ids = explode(',',$request->ids);

        $data = Variant::with('color:id,code','size:id,code','product:id,title','product.oldestImage')->whereIn('id',$ids)->get();

        return response()->json($data);
    }


    public function apiApplyCoupon(Request $request){
        $data = Coupon::where('code', $request->code)
            ->whereDate('from_valid','<=',Carbon::now())
            ->where(function ($q){
                $q->whereDate('till_valid','>=',Carbon::now())
                    ->orWhereNull('till_valid');
            })->first();

        abort_if(!$data, 404,"Invalid or Expired Coupon Code");
        return response()->json($data);

    }

}
