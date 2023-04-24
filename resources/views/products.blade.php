@extends('layouts.app')
@section('boby_content')
@push('css')
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
{{-- owslider script --}}
    <x-url-generator-js/>
<script>
    $(document).ready(function() {
                    $(".owl-carousel").owlCarousel({
                        loop: true,
                        margin: 10,
                        nav: false,
                        dots: false,
                        responsiveClass: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            600: {
                                items: 1,
                            },
                            1000: {
                                items: 1,
                                loop: false
                            }
                        }
                    });
                });




    // Products Filters

    const sortBy = (e) => {
        let sb = e.value;
        window.location.href = generateUrl({
            sb
        })
    }

    const search = () => {
        let k = document.getElementById('search_input').value;
        window.location.href = generateUrl({
            k
        });
    }
    const applyFilter = () => {
        let form = document.getElementById('filter-form');
        console.log(form)
        let formData= new FormData(form);
        let obj = {};

        for (const [key,value] of formData) {
            if (obj.hasOwnProperty(key)){
                obj={
                    ...obj,
                    [key]:`${obj[key]},${value}`
                }

            }else {
                obj = {
                    ...obj,
                    [key]:value
                }
            }
        }
        window.location.href = generateUrl(obj);
    }
</script>
@endpush



<!-- Hero Swiper -->
<div class="owl-carousel">
    <a href="#">
        <div><img src="{{ asset('images/banner.png') }}" alt="banner"></div>
    </a>
    <a href="#">
        <div><img src="{{ asset('images/banner.png') }}" alt="banner"></div>
    </a>
    <a href="#">
        <div><img src="{{ asset('images/banner.png') }}" alt="banner"></div>
    </a>
</div>


{{-- Flash sale Products --}}
<section class="px-6 md:px-20 mt-6">

    <section class="mt-6 grid grid-cols-1 md:grid-cols-5 gap-6">

        {{-- Filters --}}
        <div>
       <form id="filter-form" class="w-full md:w-auto">
            <h4 class="text-xl font-bold font-medium text-violet-800 uppercase">Filters</h4>
            {{-- Price Filter --}}
            <div>
                <h3 class="text-gray font-medium mb-2">Price</h3>
                <div class="flex justify-between items-center gap-3 text-xs">
                    <div class="flex bg-gray-300 rounded p-1 font-medium justify-between items-center gap-2 ">
                        <span class="text-gray-400">From</span>
                        <div class="flex">
                            <input type="text" name="min" pattern="[0-9]+" value="{{ request()->min }}"  class="w-8 bg-transparent focus:outline-none  text-right">
                            <span class="text-gray-800">$</span>
                        </div>
                    </div>

                    <div class="flex bg-gray-300 rounded p-1 font-medium justify-between items-center gap-2 ">
                        <span class="text-gray-400">Up To</span>
                        <div class="flex">
                            <input type="text" name="max" pattern="[0-9]+" value="{{ request()->max }}" class="w-8 bg-transparent focus:outline-none  text-right">
                            <span class="text-gray-800">$</span>
                        </div>
                    </div>

                </div>
            </div>
            <hr class="mt-2">



            {{-- Size --}}
            <div>
                <h3 class="text-gray font-medium mb-2">Size</h3>
                <ul class="text-gray-400 text-sm ">
                    @foreach($sizes as $item)
                        <li>
                            <input type="checkbox" class="flex gap-2" name="size" id="size-{{$item->id}}" value="{{$item->id}}"
                            @if(request()->size) @checked(in_array($item->id,explode(',', urldecode(request()->size)))) @endif>
                            <label class="cursor-pointer" for="size-{{$item->id}}">
                                {{ $item->name }}({{ $item->code }})
                            </label>
                        </li>
                    @endforeach
                    <input type="hidden" name="size">
                </ul>
            </div>


            <hr class="mt-2">
            {{-- Color --}}
            <div>
                <h3 class="text-gray font-medium mb-2">Color</h3>
                <ul class="text-gray-400 text-sm flex flex-col gap-2">
                    @foreach($colors as $item)

                    <li class="flex gap-2">
                        <input type="checkbox" name="color" id="color-{{$item->id}}" value="{{$item->id}}">
                        <label  class="cursor-pointer flex gap-1" for="color-{{$item->id}}"
                        @if(request()->color) @checked(in_array($item->id,explode(',', urldecode(request()->color)))) @endif>
                            <span style="background-color: {{$item->code}}" class="w-5 h-5 flex rounded-full">&nbsp;</span>{{$item->name}}
                        </label>
                    </li>
                    @endforeach
                        <input type="hidden" name="color">
                </ul>
            </div>
            <hr class="my-2">
            <div class="flex items-center justify-between">
                <a href="{{ route('products') }}">
                <button type="button" class="bg-violet-600 rounded-md text-white  text-center py-1 px-4">Apply Filter</button>
                </a>
                <span class="cursor-pointer bg-white rounded-full border w-7 h-7 p-4 flex items-center justify-center ">
                    <i class='bx bx-reset f-5' title="Reset Filter"></i>
                </span>
            </div>
       </form>
        </div>


        {{-- Products --}}
        <div class=" md:col-span-4 grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-2 flex items-center px-1.5 py-1 text-sm rounded border border-slate-300">
                <span class="w-6 border-r border-stone-300">
                    <i class='bx bx-search text-xl text-gray-400 '></i>
                </span>
                <input type="search" id="search_input" value="{{ request()->k }}" placeholder="Search 10000+Produact"
                       class="py-l-1.5 w-full bg-transparent focus:outline-none">
                <button onclick="search()" class="text-violet-500">Search</button>
            </div>

            <div class="flex items-center px-1.5 py-1 text-sm rounded border border-slate-300">
                <span class="w-6 border-r border-stone-300">
                    <i class='bx bx-filter text-xl text-gray-400 '></i>

                </span>
                <select onchange="sortBy(this)" class="py-l-1.5 w-full bg-transparent focus:outline-none">
                    <option value="">Featured</option>
                    <option value="price_asc" @selected(request()->sb == 'price_asc')>Price: Low to High</option>
                    <option value="price_desc" @selected(request()->sb == 'price_desc')>Price: High to Low</option>
                    <option value="desc" @selected(request()->sb == 'desc')>Newest Arrivals Option</option>
                </select>
            </div>





            @forelse ($products as $item)
                @if($item->variant->isNotEmpty())
                    <x-product.card1 :products="$item"/>
                @endif
            @empty
                <div class="md:col-span-3 flex flex-col justify-center items-center gap-3 ">
                    <img src="{{ asset('images/result-not-found.png') }}" alt="">
                    <h1 class="text-2xl font-bold text-gray-800">Result Not Found</h1>
                    <p class="text-gray-400 ">Try to search with another query.</p>
                </div>
            @endforelse
            <div class="md:col-span-3">
                {{$products->links()}}
            </div>
        </div>
    </section>
</section>
@endsection
