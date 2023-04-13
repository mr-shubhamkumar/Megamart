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
    <section class="px-6 md:px-28 mt-6">
        <h3 class="text-gray font-medium mb-2">Flash Sale</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach ($products as $item)
                @if($item->variant->isNotEmpty())

                    <x-product.card1 :products="$item" />
                @endif
            @endforeach
        </div>
    </section>

    {{-- Coupon Code --}}
    <section class="px-6 md:px-28 mt-10 mb-6">
        <div class=" flex flex-wrap gap-6 items-center gap-3">
            @foreach (range(1, 7) as $item)
                <div class="bg-white rounded-md shadow flex justify-between items-center">
                    <div class="flex flex-col pl-2 py-1">
                        <span class="text-gray-400">First Order</span>
                        <strong class="text-orange-500">#FKFISDFS</strong>
                    </div>

                    <div class="bg-violet-600 w-12 font-medium text-white p-3 rounded-r-md">
                        20% off
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- bast saler Products --}}
    <section class="px-6 md:px-28 mt-6">
        <div class="flex items-center justify-between">
            <div class="flex gap-2 ">
                <h3 class="text-gray font-medium mb-2 underline">Bast Saler</h3>
                <h3 class="text-gray font-medium mb-2">New Products</h3>
            </div>
            <a href="{{route('products')}}"><h3 class="text-violet-600 font-medium mb-2">All All</h3></a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach ($products as $item)
                @if($item->variant->isNotEmpty())

                <x-product.card1 :products="$item" />
                @endif
            @endforeach
        </div>
    </section>
@endsection
