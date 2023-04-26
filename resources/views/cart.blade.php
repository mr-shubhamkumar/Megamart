@extends('layouts.app')
@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>

        const isCartNotEmpty = () => {
            let items = mCart._getItems();
            return items != null ? Object.keys(items).length : 0;
        }


        const removeItem = (e, id) => {
            mCart.remove(id);
            e.parentElement.parentElement.parentElement.remove();
        }

        const applyCoupon = () => {
            let discountCode = document.getElementById('discount_code')
            if (discountCode.value == '' || discountCode.value.length == 0) return;

            axios.post(`${window.location.href}/coupon`, {
                code: discountCode.value
            })
                .then((res) => {
                    let coupon = res.data;
                    let subtotal = mCart.getSubTotal();

                    if (coupon.min_cart_amount != '' && coupon.min_cart_amount > subtotal) {
                        cuteToast({
                            type: 'error',
                            message: `Coupon Active above to$ ${coupon.min_cart_amount} Cart amount`,
                        });
                        return;
                    }

                    //   applyCoupon
                    let discount = 0;
                    if (coupon.types == 'Fixed') {
                        discount = coupon.value;
                    } else {
                        discount = ((coupon.value / 100) * subtotal).toFixed(2)
                    }
                    document.getElementById('discount_amount').textContent = discount;
                    document.getElementById('discount_massage').textContent = discount;
                    document.getElementById('total').textContent = subtotal - discount;
                })
                .catch((error) => {
                    discountCode.value = '';
                    cuteToast({
                        type: 'error',
                        message: error.response.data.message,
                    })
                })
        }

        // if (!isCartNotEmpty()) {
            setTimeout(() => {
                let items = mCart._getItems();
                let ids = Object.keys(items);
                // console.log(ids)

                axios.get(`${window.location.href}/products?ids=${ids}`)
                    .then((res) => {
                        // console.log(res.data)
                        let html = '';
                        // console.log(res.data);
                        res.data.forEach(item => {
                            let qty = mCart.getQty(item.id)
                            html += `<div class="flex gap-4 mb-3 mt-2">
                    <div class="bg-gray-100 rounded shadow p-2">
                    <img class="w-20" src="${'/storage/' + item.product.oldest_image.path}" alt="">
                    </div>
                    <div class="flex flex-col gap-1">
                        <h3 class="text-lg font-medium text-gray-800">${item.product.title}</h3>
                        <div class="text-gray-400 text-sm flex items-center cu justify-between gap-2">
                            <p class="flex gap-2">Color:<span style="background-color: ${item.color.code}" class="w-4 h-4 rounded-full">&nbsp;</span></p>
                            <p class="flex gap-2">Size:<span class=" flex justify-center  items-center p-1 w-5 h-5 rounded-full border text-center border-gray-400">${item.size.code}</span></p>
                        </div>
                        <p class="text-black text-lg font-bold">
                          $<span class="itemPrice">${item.selling_price}</span>x<span class="qty">${qty}</span>= <span>$<span class="itemTotalPrice">${item.selling_price * qty}</span></span>
                        </p>


                        <div class="flex items-center gap-6">
                            <div class="flex items-center justify-center gap-1">
                                <i onclick="mCart.manageQty(this,'${item.id}',-1,${item.stock})" class='text-gray-400 bx bxs-minus-circle text-lg cursor-pointer'></i>
                                <span class="border-gray-400 border px-3 leading-none">${qty}</span>
                                <i onclick="mCart.manageQty(this,'${item.id}',1,${item.stock})" class='text-gray-400 bx bxs-plus-circle text-lg cursor-pointer'></i>
                            </div>
                            <button onclick="removeItem(this, '${item.id}')" class="text-gray-800 rounded-md border px-2">Remove</button>
                        </div>
                    </div>
                </div>`
                        });
                        document.getElementById('itemContainer').innerHTML = html;
                        mCart.updatePrice();
                    })
                    .catch((error) => {
                        cuteToast({
                            type: 'error',
                            message: error.message,
                        })
                    });

            }, 250);



        const checkout = () => {
            if (!isCartNotEmpty()) return;

            let items = mCart._getItems();
            let is_address = document.getElementById('addresses').querySelector('input[name=address]:checked');
            if (!is_address) {
                cuteToast({
                    type: 'error',
                    message: 'Pleas select delivery address'
                });
                return;
            }

            let address = is_address.value;
            let coupon_code = null;

            let discountCode = document.getElementById('discount_code');
            if (discountCode.value != '' && discountCode.value.length != 0) {
                coupon_code = discountCode.value
            }
            ;

            axios.post("{{ route('payment.init') }}", {
                address,
                coupon_code,
                items
            })
                .then((res) => {
                    mCart.empty();
                    mCart.updatePrice();
                    let data = res.data;
                    openRazorpay(data.id, data.key, data.amount, data.razorpay_order_id)

                })
                .catch((error) => {
                    cuteToast({
                        type: 'error',
                        message: error.message
                    });
                })
        }



        @auth
        const openRazorpay = (id, key, amount, razorpay_order_id) => {
            var options = {
                'key': key,
                'amount': amount,
                'currency': 'INR',
                'name': "{{ config('app.name') }}",
                'description': 'Buy product from {{config('app.name')}}',
                'image': `${window.location.origin}/images/logo.png`,
                'order_id': razorpay_order_id,
                'callback_url': `${window.location.origin}/payment/verify/${id}`,
                'prefill': {
                    'name': "{{ auth()->user()->first_name }}",
                    'email': "{{ auth()->user()->email }}",
                    'contact': "{{ auth()->user()->mobile }}",
                },
                'theme': {
                    'color': '#00bb0',
                },
            };

            var rzp1 = new Razorpay(options);
            rzp1.on('payment.failed', (response) => {
                axios.post("{{ route('payment.failed') }}", {
                    razorpay_order_id
                })
                    .then((res) => {
                        window.location.href = "{{ route('account.index',['tab'=>'orders','msg'=>'Payment Failed!']) }}"
                    })
                    .catch((error) => {
                        window.location.reload()
                    })
            });
            rzp1.open();
        }
        @endauth


    </script>


@endpush

@section('boby_content')
    <section class="px-6 md:px-20 mt-6 min-h-screen">
        <h1 class="text-5xl font-bold text-center drop-shadow-md text-black py-12">Shopping Cart</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 ">
            {{-- Right Side --}}
            <div class="md:col-span-2 ">
                {{-- Delivery Address --}}
                <h3 class="text-gray-700 text-lg font-medium">Delivery Address</h3>
                <div
                    class=" grid grid-cols-1 md:grid-cols-6 gp4 overflow-x-auto pt-2 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-h-1">

                    <div id="addresses"
                         class="md:col-span-5 flex gap-4 overflow-x-auto pt-0 pb-0.5 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-h-1">

                        @forelse ($address as $item)
                            <label class="shrink-0 w-72 relative " for="address_{{$item->id}}">
                                <input type="radio" @checked($item->is_default_address) name="address"
                                       id="address_{{$item->id}}"
                                       value="{{$item->id}}" class="hidden peer">
                                <div
                                    class="p-2 border border-slate-300 peer-checked:border-violet-600 rounded-md cursor-pointer">
                                    <div class="flex justify-between items-center">
                                            <span
                                                class="text-black font-bold ">{{$item->first_name." ".$item->last_name}}</span>
                                        <a href="{{route('address.edit',$item->id)}}"
                                           class="text-gray-400 cursor-pointer"><i class='bx bx-pencil'></i>Edit</a>
                                    </div>
                                    <p class="text-gray-400 leading-4 text-sm">{{$item->street_address." ".$item->district." ".$item->state." ".$item->pin_code}}
                                    </p>
                                    <p class="text-gray-500 text-sm">Mobile No: +91 {{$item->mobile_no}}</p>
                                </div>
                                <i
                                    class='hidden peer-checked:block bx bxs-check-circle text-xl -right-2 text-violet-600 bg-white absolute -top-3'></i>
                            </label>

                        @empty
                            login
                        @endforelse
                    </div>

                    <a href="{{ route('address.create') }}"
                       class="bg-slate-300 rounded-md px-4 shrink-0  flex flex-col items-center justify-center">
                        <i class='bx bxs-plus-circle text-lg'></i>
                        <span class="text-gray-400 text-sm">Address</span>
                    </a>
                </div>
                {{-- Delivery Address End --}}

                <div id="itemContainer" class=" grid-cols-1 md:grid-cols-1 gap-3 "></div>
            </div>
            {{-- Right Side End --}}

            {{-- left Side --}}
            <div>
                <div class="bg-white rounded-md shadow-md p-2">
                    <h3 class="mb-3 text-black font-medium uppercase">Order Datails</h3>

                    <div class="relative p-2 py-2 mb-2 border border-slate-300 rounded-md">
                        <label class="absolute -top-3.5 left-5 text-slate-300 bg-white px-1">Discount Code</label>
                        <div class="flex justify-between">
                            <input name="discount_code" id="discount_code" class="w-full focus:outline-none" type="text"
                                   placeholder="Enter Discount Code">
                            <button type="button" onclick="applyCoupon()" class="text-violet-600 font-medium">Apply
                            </button>
                        </div>
                    </div>


                    <div class="flex justify-between item-center">
                        <span class="text-gray-400">Subtotal</span>
                        <span class="text-gray-800 font-bold">$<span id="subtotal">0</span></span>
                    </div>
                    <div class="flex justify-between item-center">
                        <span class="text-gray-400">Shopping Cost</span>
                        <span class="text-gray-800 font-bold">$0</span>
                    </div>
                    <div class="mb-2 flex justify-between item-center">
                        <span class="text-gray-400">Discount</span>
                        <span class="text-violet-600 font-bold">$<span id="discount_amount"></span></span>
                    </div>

                    <div class="flex justify-between item-center">
                        <span class="text-gray-400">Total</span>
                        <span class="text-gray-800 font-bold"><span id="total">0</span></span>
                    </div>
                    <div class="mb-1 flex justify-between item-center bg-green-100 p-2 rounded">
                        <span class="text-green-500">Your total Savings amount  on <br> this order</span>
                        <span class="text-green-500 font-bold">$<span id="discount_massage"></span></span>
                    </div>
                    <button type="button" onclick="checkout()"
                            class=" mt-3 bg-violet-600 text-white font-bold text-center w-full rounded py-1 shadow">
                        Checkout
                    </button>
                </div>
            </div>
            {{-- left Side End --}}
        </div>


        {{--    <div>--}}
        {{--        <h3 class="mb-4 text-gray-700 text-lg font-medium">Payment  Method</h3>--}}
        {{--        <div class="flex flex-wrap gap-4">--}}
        {{--            <label for="" class="border border-slate-300 rounded p-2">--}}
        {{--                <input type="text" name="payment_method" class="hidden peer">--}}
        {{--                <span class="text-gray-400 font-medium uppercase">Pay On Delivery</span>--}}
        {{--            </label>--}}

        {{--            <label for="" class="border border-slate-300 rounded p-2">--}}
        {{--                <input type="text" name="payment_method" class="hidden peer">--}}
        {{--                <span class="text-gray-400 font-medium uppercase">UPI</span>--}}
        {{--            </label>--}}

        {{--            <label for="" class="border border-slate-300 rounded p-2">--}}
        {{--                <input type="text" name="payment_method" class="hidden peer">--}}
        {{--                <span class="text-gray-400 font-medium uppercase">Paytm</span>--}}
        {{--            </label>--}}
        {{--        </div>--}}
        {{--    </div>--}}
    </section>
@endsection
