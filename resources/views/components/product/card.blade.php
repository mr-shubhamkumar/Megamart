<a href="{{ route('product_details')}}">
    <div class="bg-white rounded-lg shadow-lg p-3 relative">
    <img class="mx-auto" src="{{ asset('images/product-1.png') }}" alt="">

    <div class="flex justify-between gap-3 my-3">
        <p class="text-lg font-medium text-gray-800">Mens Casual Slim Fit T-Shert</p>
        <div class="flex flex-col item-end">
            <strong class="text-violet-600">$500</strong>
            <strike class="text-gray-400">$599</strike>
        </div>

    </div>
    <div class="flex justify-between items-center mb-2">
        <div class="flex gap-1">
            <span style="background-color: #d80909" class="w-5 h-5 rounded-full">&nbsp;</span>
            <span style="background-color: #5012fa" class="w-5 h-5 rounded-full">&nbsp;</span>
            <span style="background-color: #030303" class="w-5 h-5 rounded-full">&nbsp;</span>
        </div>
        <div class="flex gap-1 text-gray-400 text-sm">
            <span class=" flex justify-center  items-center p-3 w-5 h-5 rounded-full border text-center border-gray-400">M</span>
            <span class=" flex justify-center items-center p-3 w-5 h-5 rounded-full border text-center border-gray-400">S</span>
            <span class=" flex justify-center items-center p-3 w-5 h-5 rounded-full border text-center border-gray-400">L</span>
        </div>
    </div>
    <div class="flex justify-between text-center">
        <span class="text-gray-400"> <i class='bx bx-star'></i>4.5</span>
        <span class="text-violet-600 flex text-center font-bold"> <i class='bx bx-cart-add text-2xl' ></i>Buy Now</span>
    </div>

    <div class="absolute top-2  left-3 right-3 items-center flex justify-between ">
        <span class="bg-red-500 text-white rounded px-2">25% off</span>
        <span class="bg-white shadow-md rounded-full w-7 h-7 flex items-center justify-center "><i class='bx bx-heart text-2xl' ></i></span>
    </div>
</div>

</a>