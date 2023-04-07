@extends('layouts.app')
@push('scripts')
<script>
</script>
@endpush

@section('boby_content')
<section class="px-6 md:px-20 mt-6 min-h-screen">
<h1 class="text-5xl font-bold text-center drop-shadow-md text-black py-12">WishList</h1>


<div class="grid grid-cols-1 md:grid-cols-2 gap-3 ">
    @foreach (range(1,6) as $item)
    <div class="flex gap-4 mb-3 mt-2">
        <div class="bg-gray-100 rounded shadow p-2">
            <img class="w-20" src="{{asset('images/product-1.png')}}" alt="">
        </div>
        <div class="flex flex-col gap-1">
            <h3 class="text-lg font-medium text-gray-800">Men Blue Shirt</h3>
            <div class="text-gray-400 text-sm flex items-center justify-between gap-2">
                <p class="flex gap-2">Color:<span style="background-color: #d80909"
                        class="w-4 h-4 rounded-full">&nbsp;</span></p>
                <p class="flex gap-2">Size:<span
                        class=" flex justify-center  items-center p-1 w-5 h-5 rounded-full border text-center border-gray-400">M</span>
                </p>
            </div>
            <p class="text-black text-lg font-bold">$500 <sub class="text-sm  font-normal text-red-500">$599 <span
                        class="text-gray-400">(25% off)</span></sub></p>


            <div class="flex items-center gap-6">
               
                <button class="text-violet-800 rounded-md border font-bold px-2">Add To Cart</button>
                <button class="text-gray-800 rounded-md border font-bold px-2">Remove</button>
            </div>
        </div>
    </div>
    @endforeach
</div>
</section>
@endsection