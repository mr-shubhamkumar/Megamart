@extends('layouts.app')
@section('boby_content')
@push('css')
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
{{-- owslider script --}}
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
       <div class="w-full md:w-auto">
        <div class=" p-3 rounded border border-slate-300">
            <h4 class="text-xl font-bold font-medium text-violet-800 uppercase">Filters</h4>
            {{-- Price Filter --}}
            <div>
                <h3 class="text-gray font-medium mb-2">Price</h3>
                <div class="flex justify-between items-center gap-3 text-xs">
                    <div class="flex bg-gray-300 rounded p-1 font-medium justify-between items-center gap-2 ">
                        <span class="text-gray-400">From</span>
                        <div class="flex">
                            <input type="text" class="w-8 bg-transparent focus:outline-none  text-right" value="0">
                            <span class="text-gray-800">$</span>
                        </div>
                    </div>
        
                    <div class="flex bg-gray-300 rounded p-1 font-medium justify-between items-center gap-2 ">
                        <span class="text-gray-400">Up To</span>
                        <div class="flex">
                            <input type="text" class="w-8 bg-transparent focus:outline-none  text-right" value="0">
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
                    <li><input type="checkbox" name="" id="small"><label for="small"> Small</label></li>
                    <li><input type="checkbox" name="" id="medium"><label for="medium"> Medium</label></li>
                    <li><input type="checkbox" name="" id="large"><label for="large"> Large</label></li>
                </ul>
            </div>
        
        
            <hr class="mt-2">
            {{-- Color --}}
            <div>
                <h3 class="text-gray font-medium mb-2">Color</h3>
                <ul class="text-gray-400 text-sm flex flex-col gap-2">
                    <li class="flex gap-2">
                        <input type="checkbox" name="" id="color1"><label for="color1">
                            <span style="background-color: #d80909" class="w-5 h-5 flex rounded-full">&nbsp;</span>
                        </label>
                    </li>
                    <li class="flex gap-2">
                        <input type="checkbox" name="" id="color2">
                        <label for="color2">
                            <span style="background-color: #5012fa" class="w-5 h-5 flex rounded-full">&nbsp;</span>
                        </label>
                    </li>
                    <li class="flex gap-2"><input type="checkbox" name="" id="color3">
                        <label for="color3">
                            <span style="background-color: #030303" class="w-5 h-5 flex rounded-full">&nbsp;</span>
                        </label>
                    </li>
                </ul>
            </div>
            <hr class="my-2">
            <div class="flex items-center justify-between">
                <button class="bg-violet-600 rounded-md text-white  text-center py-1 px-4">Apply Filter</button>
                <span class="cursor-pointer bg-white rounded-full border w-7 h-7 p-4 flex items-center justify-center "><i
                        class='bx bx-reset f-5' title="Reset Filter"></i></span>
            </div>
        </div>
       </div>


        {{-- Products --}} 
        <div class=" md:col-span-4 grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="md:col-span-2 flex items-center px-1.5 py-1 text-sm rounded border border-slate-300">
                <span class="w-6 border-r border-stone-300">
                    <i class='bx bx-search text-xl text-gray-400 '></i>
                </span>
                <input type="search" placeholder="Search 10000+Produact" class="py-l-1.5 w-full bg-transparent focus:outline-none">
            </div>

            <div class="flex items-center px-1.5 py-1 text-sm rounded border border-slate-300">
                <span class="w-6 border-r border-stone-300">
                    <i class='bx bx-filter text-xl text-gray-400 '></i>
                    
                </span>
                <select class="py-l-1.5 w-full bg-transparent focus:outline-none">
                    <option value="">Populer</option>
                </select>
            </div>
           


            
            @foreach (range(1, 12) as $item)
            <x-product.card />
            @endforeach
        </div>
    </section>
</section>
@endsection