<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\Coupon;
use App\Models\Variant;
use App\Models\OrderItem;
use App\Models\UserAddress;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function index()
    {
        $address = [];
        if (auth()->check()) {
            $address = UserAddress::where('user_id', auth()->user()->id)->get();
        }
//        return  $address;
        return view('cart', compact('address'));
    }

    public function apiCartProducts(Request $request)
    {
        $ids = explode(',', $request->ids);

        $data = Variant::with('color:id,code', 'size:id,code', 'product:id,title', 'product.oldestImage')->whereIn('id', $ids)->get();

        return response()->json($data);
    }


    public function apiApplyCoupon(Request $request)
    {
        $data = Coupon::where('code', $request->code)
            ->whereDate('from_valid', '<=', Carbon::now())
            ->where(function ($q) {
                $q->whereDate('till_valid', '>=', Carbon::now())
                    ->orWhereNull('till_valid');
            })->first();

        abort_if(!$data, 404, "Invalid or Expired Coupon Code");
        return response()->json($data);

    }


    //Peyment Function
    public function initPeyment(Request $request)
    {
        $variant_ids = array_keys($request->items);

        $variants = Variant::whereIn('id', $variant_ids)->get();

        $total = (float)$variants->sum('selling_price');

        $count = $variants->count();

        //Coupon code
        $coupon_id = null;
        $discount = 0;
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)
                ->whereDate('from_valid', '<=', Carbon::now())
                ->where(function ($q) {
                    $q->whereDate('till_valid', '>=', Carbon::now())
                        ->orWhereNull('till_valid');
                })->first();


            if (isset($coupon->min_cart_amount) && $coupon->min_cart_amount > $total) {

            } else {
                $coupon_id = $coupon->id;
                if ($coupon->type == 'Fixed') {
                    $discount = (float)$coupon->value;
                } else {
                    $discount = round((((float)$coupon->value / 100) * $total), 2);
                }
            }
        }
        #Coupon Code End

        #Save Order Details
        $order = new Order;
        $order->user_id = auth()->user()->id;
        $order->user_address_id = $request->address;
        if ($coupon_id) $order->coupon_id = $coupon_id;
        $order->total_amount = $variants->sum('selling_price');
        $order->discount_amount = $discount;
        $order->status = 'PENSING';
        $order->save();


        //Save Order Item Detail
        foreach ($variants as $variant) {
            $qty = $request->items[$variant->id];

            OrderItem::create([
                'order_id' => $order->id,
                'variant_id' => $variant->id,
                'qty' => $qty,
                'mrp' => $variant->mrp,
                'price' => $variant->selling_price,
            ]);

        }

        $total = (float)$order->total_amount - (float)$order->discount_amount;

        # Razorpay
        $api = new \Razorpay\Api\Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $razorpayOrder = $api->order->create([
            'receipt' => "Total $count items in this order",
            'amount' => $total * 100,
            'currency' => 'INR'
        ]);

        $order->razorpay_order_id = $razorpayOrder['id'];
        $order->razorpay_order_status = 'created';

        $order->save();

        return response()->json([
            'id' => $order->id,
            'key' => env('RAZORPAY_KEY'),
            'razorpay_order_id' => $order->razorpay_order_id,
            'amount' => $razorpayOrder['amount']
        ]);

    }

    public function peymentFailed(Request $request)
    {

        Order::where('razorpay_order_id', $request->razorpay_order_id)
            ->update([
                'payment_status' => 'Failed'
            ]);

        return response()->json([]);
    }


    public function peymentVerify(Request $request, $id)
    {



        if ($request->razorpay_payment_id != null) {
            $order = Order::find($id);

            try {

                $api =  new \Razorpay\Api\Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
                $api->utility->verifyPaymentSignature([
                    'razorpay_payment_id'=>$request->razorpay_payment_id,
                    'razorpay_order_id'=>$request->razorpay_order_id,
                    'razorpay_signature'=>$request->razorpay_signature,
                ]);

                // dd($request->all());


                $order->payment_status = 'Success';
                $order->razorpay_order_status = 'paid';
                $order->status = 'PAID OUT';

                # Decrease Stock Quantity
                $orderItems = OrderItem::where('order_id', $order->id)
                    ->select(['variant_id','qty'])
                    ->get();

                foreach ($orderItems as $item){
                    $variant = Variant::find($item->variant_id);
                    $variant->decrement('stock', $item->qty);
                }

            } catch (\Throwable $th) {
                $order->razorpay_order_status = 'attempted';
                $order->payment_status = 'Failed';
            }

            $order->razorpay_payment_id = $request->razorpay_payment_id;
            $order->save();
        }


        return redirect()->route('account.index', [
            'tab' => 'orders',
            'msg' => "Payment $order->payment_status"
        ]);
    }

}
