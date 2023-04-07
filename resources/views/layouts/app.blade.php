<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    @stack('css')
    <!-- Styles -->
    @vite('resources/css/app.css')
    <!-- Styles -->

</head>
{{-- Header --}}

<body class="bg-[#FBFBFB]">
    <header class="flex justify-between px-6 md:px-20 bg-white shadow py-2 items-center">
        <a href="/">
        <img src="{{ asset('images/logo.png') }}"  alt="logo" width="100" height="80">
        </a>
        <div class="text-2xl relative">
            <a href="{{ route('wishlist') }}"><i class='bx bx-heart'></i></a>
            <a href="{{ route('account') }}"><i class='bx bx-user'></i></a>
            
            <a href="{{ route('cart') }}"><i class='bx bx-cart'></i></a>
            <span
                class="absolute top-0 -right-2.5 bg-indigo-500 rounded-full w-5 h-5 text-xs text-center text-white">0</span>
        </div>
    </header>


    <main>
        @yield('boby_content')
    </main>

    <footer class="px-6 md:px-28 mt-6">
        <div class="grid col-1 md:grid-cols-3 gap-5">
            <div>
                <img src="{{ asset('images/logo.png') }}" width="100" alt="">
                <ul class="mt-4 text-gray-800">
                    <li><i class='bx bx-map'></i>UP, Varanasi, India</li>
                    <li><i class='bx bx-phone'></i>+91 8957168425</li>
                    <li><i class='bx bx-envelope'></i>shri.shubham.kr@gmail.com</li>
                </ul>
            </div>
            <div>
                <h1 class="text-lg font-medium">Categorys</h1>
                <ul class="mt-1 text-gray-800">
                    <li>Category 1</li>
                    <li>Category 1</li>
                    <li>Category 1</li>
                    <li>Category 1</li>
                    <li>Category 1</li>
                </ul>
            </div>
            <div>
                <h1 class="text-lg font-medium">Further Info</h1>
                <ul class="mt-1 text-gray-800">
                    <li>Home</li>
                    <li>About Us</li>
                    <li>Contact Us</li>
                    <li>Privacy Policy</li>
                    <li>Terms of Use</li>
                </ul>
            </div>

        </div>
        <p class="text-gray-400 text-center my-3">Copyright &copy; {{ date('Y') }} MegaMart </p>
    </footer>


    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    
    @stack('scripts')
</body>

</html>
