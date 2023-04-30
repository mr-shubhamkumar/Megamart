<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        if ($request->method() == "POST") {
            $request->validate([
                'first_name' => 'required|max:25',
                'last_name' => 'required|max:25',
                'email' => 'required',
                'mobile' => 'required|max:10'

            ]);
            $user = User::find(auth()->user()->id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;

            $user->save();
            return back()->with('success', 'Profile information update');
        }

 $orders = [];
        $addresses = [];
        if (auth()->check()) {
            $user_id = auth()->user()->id;

            $addresses =  UserAddress::where('user_id', $user_id)->get();

            $orders = Order::query()
                ->with('items:order_id,variant_id')
                ->where('user_id', $user_id)
                ->get();
        }

        foreach ($orders as $k => $order) {
            $variant_ids = array_column($order->items->toArray(), 'variant_id');

            $products = Product::whereIn(
                'id',
                fn ($q) => $q->select('product_id')->from('variants')->whereIn('id', $variant_ids)
            )
                ->with('oldestImage')
                ->get();

            $images = array_column($products->toArray(), 'oldest_image');
            $orders[$k]['images'] = array_column($images, 'path');
        }

        return view('account', compact('orders', 'addresses'));

    }


    //Address ==========================================================================

    public function newAddress(Request $request)
    {
        if ($request->method() == "GET") return view('new_address');

        abort_if(!auth()->check(), 404);

        $request->validate([
            'is_default_address' => 'required',
            'tag' => 'required|max:50',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'mobile_no' => 'required|max:50',
            'street_address' => 'required|max:50',
            'district' => 'required|max:50',
            'state' => 'required|max:50',
            'pin_code' => 'required|max:50',

        ]);
        // return $request->all();

        $address = new UserAddress();

        $address->user_id = auth()->user()->id;

        $address->is_default_address = $request->is_default_address;
        $address->tag = $request->tag;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->mobile_no = $request->mobile_no;
        $address->street_address = $request->street_address;
        $address->district = $request->district;
        $address->state = $request->state;
        $address->pin_code = $request->pin_code;
        $address->note = $request->note;
        $address->save();

        if ($address->is_default_address) self::setDefaultAddress(address_id:  $address->id);
        return redirect()->route('account.index', ['tab' => 'address'])->withSuccess('New Delivery Address Added');

    }
    private static function setDefaultAddress($address_id)
    {
        UserAddress::where('user_id', auth()->user()->id)->where('id', "!=", $address_id)->update(['is_default_address' => false]);
    }



    public function editAddress(Request $request, $id)
    {
        if ($request->method() == "GET"){

            $data = auth()->check()? UserAddress::find($id)->first() :[];
            return view('edit_address',compact('data'));
        }
        abort_if(!auth()->check(), 404);

        $request->validate([
            'is_default_address' => 'required',
            'tag' => 'required|max:50',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'mobile_no' => 'required|max:50',
            'street_address' => 'required|max:50',
            'district' => 'required|max:50',
            'state' => 'required|max:50',
            'pin_code' => 'required|max:50',

        ]);
        // return $request->all();

        $address =  UserAddress::find($id);

        $address->is_default_address = $request->is_default_address;
        $address->tag = $request->tag;
        $address->first_name = $request->first_name;
        $address->last_name = $request->last_name;
        $address->mobile_no = $request->mobile_no;
        $address->street_address = $request->street_address;
        $address->district = $request->district;
        $address->state = $request->state;
        $address->pin_code = $request->pin_code;
        $address->note = $request->note;
//        dd($address);
        $address->save();
        if ($address->is_default_address) self::setDefaultAddress(address_id:  $address->id);
        return redirect()->route('account.index', ['tab' => 'address'])->withSuccess('Delivery Address Updated');


    }


    //Address End ==========================================================================

    // Order start ==========================================================================
    public function showOrder($id)
    {
        $order = [];

        if (auth()->check()) {
            $order = Order::with([
                'items.variant.color:id,code',
                'items.variant.size:id,code',
                'items.variant.product:id,title',
                'items.variant.product.oldestImage',
            ])
                ->where('user_id', auth()->user()->id)
                ->where('id', $id)
                ->first();
        }
//        return $order;

        return view('show_order', compact('order'));
    }
    //Order End ==========================================================================
}
