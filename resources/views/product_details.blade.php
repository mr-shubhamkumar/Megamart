@extends('layouts.app')
@push('scripts')
<script>
    let currentImage = 0;

        const viewImage = (e, index) => {
            currentImage = index;
            document.getElementById('bigImage').src = e.querySelector('img').src;
        }

        const nextPrevious = (index) => {
            i = currentImage + index;
            let images = document.getElementById('images').querySelectorAll('img');

            if (i >= images.length || i < 0) return;
            currentImage = i;
            let arr = [];

            images.forEach(element => arr.push(element.src));

            document.getElementById('bigImage').src = arr[currentImage];
        }
</script>
@endpush

@section('boby_content')
<section class="px-6 md:px-20 mt-6">
    <div class="flex flex-wrap md:flex-nowrap gap-6">
        {{-- Left --}}

        <div class="shrink-0 w-full md:w-auto flex flex-col-reverse md:flex-row gap-4">

            <div id="images" class="flex md:flex-col gap-3 pb-1 md:pb-0 max-h-96 overflow-y-auto">
                @foreach ($product->image as $image)
                <div onclick="viewImage(this, {{ $image->id }})"
                    class="bg-white rounded-md shadow p-1 cursor-pointer">
                    <img class="w-14" src="{{ asset('storage/' . $image->path) }}" alt="" srcset="">
                </div>
                @endforeach
            </div>
            <div class="h-96 relative  bg-white rounded-md shadow-md p-3">
                <img id="bigImage" class="h-full aspect-[2/3]" src="{{ asset('storage/' . $product->image[0]->path) }}" alt="">
                <span onclick="nextPrevious(-1)"
                    class="absolute top-1/2 left-2  bg-white rounded-full w-5 h-5 shadow flex items-center justify-center"><i
                        class='bx bx-chevron-left text-xl text-gray-400 cursor-pointer hover:text-violet-600 duration-200'></i>
                </span>
                <span onclick="nextPrevious(1)"
                    class="absolute top-1/2 right-2  bg-white rounded-full w-5 h-5 shadow flex items-center justify-center">
                    <i
                        class='bx bx-chevron-right text-xl text-gray-400 cursor-pointer hover:text-violet-600 duration-200'></i>
                </span>
            </div>


        </div>
        {{-- Left End --}}


        {{-- Right --}}
        <div class="w-full flex flex-col gap-4">
            <div class="flex gap-3">
                @php
                  $discount=   (($product->variant[0]->mrp - $product->variant[0]->selling_price)/$product->variant[0]->mrp)*100;
                @endphp
                <span class="bg-red-500 text-white rounded px-2">{{round($discount,2)}}%</span>
                <span class="text-gray-400 text-sm"> <i class='bx bx-star'></i>4.5</span>
            </div>
            <h2 class=" text-lg font-medium text-gray-800">{{$product->title}}</h2>
            <div class="text-sm text-gray-800">
                <p><span class="text-gray-400">SKU:</span> {{$product->variant[0]->sku}}</p>
                <p><span class="text-gray-400">Brand:</span> {{$product->brand->name}}</p>
            </div>

            <div>
                <span class="to-orange-500 font-bold text-lg ">${{$product->variant[0]->selling_price}}</span>
                <sub class="text-gray-400"><strike>${{$product->variant[0]->mrp}}</strike></sub>
            </div>
            {{-- color --}}

            {{-- sku and brand --}}
            <div>
                <p class="text-gray-400">Colors:</p>
                <div class="flex gap-1">
                    @foreach($product->variant as $item)
                        <span style="background-color: {{$item->color->code}}" class="w-7 h-7 rounded-full border-2">&nbsp;</span>

                    @endforeach
                </div>
            </div>

            {{-- sizes --}}
            <div>
                <p class="text-gray-400">Size:</p>
                <div class="flex gap-1 text-gray-400 text-sm">
                    @foreach($product->variant as $item)
                        <span class=" flex justify-center  items-center p-3 w-5 h-5 rounded-full border text-center border-gray-400">{{$item->size->code}}</span>
                    @endforeach
                </div>
                <a href="#" class="text-gray-400 text-xs">Size Guide</a>
            </div>

            {{-- Quntity --}}
{{--            <div>--}}
{{--                <p class="text-gray-400">Quntity</p>--}}
{{--                <div class="flex  items-center gap-2">--}}
{{--                    <input type="text" readonly value="1"--}}
{{--                        class="bg-slate-200-200 rounded border border-gray-300 focus:outline-none px:2 text-lg font-medium w-20">--}}
{{--                    <button class="rounded border w-7 h-7 border border-gray-300"><i--}}
{{--                            class='bx bx-plus text-lg text-gray-800'></i></button>--}}
{{--                    <button class="rounded border w-7 h-7 border border-gray-300"><i--}}
{{--                            class='bx bx-minus text-lg text-gray-800'></i></button>--}}
{{--                </div>--}}
{{--            </div>--}}

            {{-- Wislist, Add to Cart, BUY Now --}}
            <div class="flex items-center gap-4">
                <span class="bg-white shadow-md rounded-full w-8 h-8 flex items-center justify-center ">
                    <i class='bx bx-heart text-2xl text-gray-500'></i>
                </span>

                <button
                    class="border text-violet-600 border-violet-600 rounded w-28 text-center drop-shadow font-medium py-0.5">Add
                    To Cart</button>
                <button
                    class="border text-white bg-violet-600 border-violet-600 rounded w-28 text-center drop-shadow font-medium py-0.5">Buy
                    Now</button>
            </div>
        </div>

    </div>
    {{-- Right End --}}
    {{--Products Descrition --}}
    <div>
        <h1 class=" mb-6 text-lg text-gray-400 font-medium">Products Descrition</h1>
        <div>
            <p class="text-gray-600">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. In illum, asperiores nostrum explicabo
                incidunt dolorem fugit totam non voluptatibus rerum, dicta similique assumenda sed odio. Veritatis amet
                suscipit beatae adipisci, excepturi, ab odit ipsum repudiandae quo ullam velit optio voluptas possimus
                omnis? Praesentium, nisi vitae a laborum laboriosam tempore eum voluptatum commodi, voluptatem quis est
                ut ipsum quisquam libero, tenetur nihil deleniti amet cum earum itaque perspiciatis facere! Tenetur nam
                numquam, nobis excepturi a totam quisquam impedit rerum fuga placeat ut quaerat dicta modi inventore
                repellat vel vero.
            </p>
        </div>
    </div>


    {{-- Featured Products --}}
    <section class=" mt-6">
        <h3 class="text-gray font-medium mb-2">Featured Products</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach ($products as $item)
                @if($item->variant->isNotEmpty())

                    <x-product.card1 :products="$item" />
                @endif
            @endforeach
        </div>
    </section>

</section>
@endsection
