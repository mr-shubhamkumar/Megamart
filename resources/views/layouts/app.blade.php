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
            @auth
            <a href="{{ route('account') }}"><i class='bx bx-user'></i></a>
            @else
            <button onclick="toggleLoginPopup()" ><i class='bx bx-user'></i></button>
            @endauth
            <a href="{{ route('cart') }}"><i class='bx bx-cart'></i></a>
            <span
                class="absolute top-0 -right-2.5 bg-indigo-500 rounded-full w-5 h-5 text-xs text-center text-white">0</span>
        </div>
    </header>


    <main>
        @yield('boby_content')
        <div id="login-popup" class="absolute
            top-14 right-1/2 md:right-1 left-1/2 md:left-auto
            -translate-x-1/2 md:translate-x-0 z-50
             bg-white border rounded shadow-lg py-2 w-11/12 md:w-80 hidden">
            <h2 id="form-title" class="text-center capitalize text-lg font-bold">Login</h2>

             {{-- Login Form--}}
            <form action="" method="post" id="login" class="grid grid-cols-1 gap-3 p-2">
                <div class="relative border rounded ">
                    <label class="text-gray-400 bg-white px-1 absolute -top-3 left-3">Email</label>
                    <input type="email" name="email" placeholder="Enter Your Email" class="w-full px-2 pt-1.5 placeholder-slate-300 bg-transparent  focus:outline-none">
                </div>

                <div class="relative border rounded ">
                    <label class="text-gray-400 bg-white px-1 absolute -top-3 left-3">Password</label>
                    <input type="password" name="password" placeholder="Enter Your Password" class="w-full px-2 pt-1.5 placeholder-slate-300 bg-transparent  focus:outline-none">
                <button type="button"  onclick="toggleForms('forgot')" class="absolute -bottom-5 text-gray-400 left-2 text-sm">Forgot Password</button>
                </div>

                <button type="button" onclick="login()" class="bg-violet-500 mt-4 text-white font-medium py-1 rounded">Login</button>
                <button type="button" onclick="toggleForms('register')" class="text-sm text-gray-400 ">Don't have an account <span class="text-violet-500 underline">Register Now</span> </button>
            </form>



            {{-- Register Form--}}
            <form action="" method="post" id="register" class="grid capitalize grid-cols-1 gap-3 p-2 hidden">
                <div class="relative border rounded ">
                    <label class="text-gray-400 bg-white px-1 absolute -top-3 left-3">First Name</label>
                    <input type="text" name="first_name" placeholder="Enter Your Email" class="w-full px-2 pt-1.5 placeholder-slate-300 bg-transparent  focus:outline-none">
                </div>

                <div class="relative border rounded ">
                    <label class="text-gray-400 bg-white px-1 absolute -top-3 left-3">Last Name</label>
                    <input type="text" name="last_name" placeholder="Enter Your Email" class="w-full px-2 pt-1.5 placeholder-slate-300 bg-transparent  focus:outline-none">
                </div>
                <div class="relative border rounded ">
                    <label class="text-gray-400 bg-white px-1 absolute -top-3 left-3">Email</label>
                    <input type="email" name="email" placeholder="Enter Your Email" class="w-full px-2 pt-1.5 placeholder-slate-300 bg-transparent  focus:outline-none">
                </div>

                <div class="relative border rounded ">
                    <label class="text-gray-400 bg-white px-1 absolute -top-3 left-3">Password</label>
                    <input type="password" name="password" placeholder="Enter Your Password" class="w-full px-2 pt-1.5 placeholder-slate-300 bg-transparent  focus:outline-none">
                </div>

                <button type="button" onclick="register()" class="bg-violet-500 mt-4 text-white font-medium py-1 rounded">Register</button>
                <button type="button" onclick="toggleForms('login')" class="text-sm text-gray-400 ">Already have an account <span class="text-violet-500 underline">Login Now</span> </button>
            </form>



            {{-- Forget Password Form--}}
            <form action="" method="post" id="forgot" class="grid grid-cols-1 gap-3 p-2 hidden">
                <div class="relative border rounded ">
                    <label class="text-gray-400 bg-white px-1 absolute -top-3 left-3">Email</label>
                    <input type="email" name="email" placeholder="Enter Your Email" class="w-full px-2 pt-1.5 placeholder-slate-300 bg-transparent  focus:outline-none">
                </div>
                <div>

                    <button type="button" onclick="toggleForms('login')" class="text-sm text-gray-400 ">Login</button>
                </div>

                <button type="button" onclick="forgot()" class="bg-violet-500 mt-4 text-white font-medium py-1 rounded">Send Reset Link</button>

            </form>


        </div>
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

    @vite('resources/js/app.js')
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>

    <script>
        const  toggleForms = (id)=>{
            let loginForm = document.getElementById('login');
            let registerForm = document.getElementById('register');
            let forgetForm = document.getElementById('forgot');


            loginForm.classList.add('hidden')
            registerForm.classList.add('hidden');
            forgetForm.classList.add('hidden');
            document.getElementById(id).classList.remove('hidden')

            document.getElementById('form-title').innerHTML = id;
        }

        const toggleLoginPopup = ()=>document.getElementById('login-popup').classList.toggle('hidden');



        // Authentication Functions
        const login = async ()=>{
            const form = document.getElementById('login');
            const formData = new FormData(form);

            let isError = false;

            for (const [key, value] of formData){
                if (value.length == 0 || value == '') isError = true;
            }

            if (isError){
                alert('Fill required fields');
                return;
            }

            try {
                let response = await axios.post('/login', formData);
                if (response.status == 200){
                    window.location.reload();
                }else {
                    alert(response.data.msg)
                }
            }catch (error) {
                alert(error.response.data.msg)
            }

        }

        // Registre
        const register = async ()=>{
            const form = document.getElementById('register');
            const formData = new FormData(form);

            let isError = false;

            for (const [key, value] of formData){
                if (value.length == 0 || value == '') isError = true;
            }

            if (isError){
                alert('Fill required fields');
                return;
            }

            try {
                let response = await axios.post('/register', formData);
                if (response.status == 200){
                    window.location.reload();
                }else {
                    alert(response.data.msg)
                }
            }catch (error) {
                let errors = Object.values(error.response.data);
                let msg = '';
                errors.forEach(err =>{
                    msg += err +'\n';
                });


                if (msg != '') alert(msg);

            }
        }

       // Forgot

        const forgot = async ()=>{
            const form = document.getElementById('forgot');
            const formData = new FormData(form);

            let isError = false;

            for (const [key, value] of formData){
                if (value.length == 0 || value == '') isError = true;
            }

            if (isError){
                alert('Fill required fields');
                return;
            }

            try {
                let response = await axios.post('/forgot', formData);

                    alert(response.data.msg)
            }catch (error) {
                alert(error.response.data.msg)
            }

        }

    </script>

    @stack('scripts')
</body>

</html>
