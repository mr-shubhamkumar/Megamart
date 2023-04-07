@extends('layouts.app')
@push('scripts')
<script>
    const activeTab = (id)=>{
        let tab = document.getElementById(id)
        let tabContainer = document.getElementById('tabContainer').querySelectorAll('.tabContent');
      
        tabContainer.forEach(element => {
            element.classList.add('hidden');
        });
        document.getElementById(id).classList.remove('hidden')



        let navLink = document.getElementById('tabLink').querySelectorAll('li');
        navLink.forEach(element => {
        element.classList.remove('text-violet-600');
        element.classList.remove('underline');
        });
        document.getElementById(`nav-${id}`).classList.add('text-violet-600')
        document.getElementById(`nav-${id}`).classList.add('underline')

       const url = new URL(window.location);
       url.searchParams.set('tab',id);
       window.history.pushState({},'',url)
    }
    @if (request()->tab)
        activeTab('{{request()->tab}}')
    @endif
</script>
@endpush

@section('boby_content')
<div class="px-6 md:px-20 md:min-h-screen grid grid-cols-1 md:gap-2 md:grid-cols-6 gap-4">
    <div class="">
        <ul id="tabLink" class="flex md:flex-col flex-wrap justify-between gap-3">
            <li id="nav-profile" onclick="activeTab('profile')" class="cursor-pointer">My Profile</li>
            <li id="nav-orders" onclick="activeTab('orders')"  class="cursor-pointer">My Orders</li>
            <li id="nav-address" onclick="activeTab('address')"  class="cursor-pointer">My Address</li>
            {{-- <li onclick="activeTab()">Acount Setting</li> --}}
        </ul>
    </div>

    {{-- Right Side --}}
    <div class="md:col-span-5 ">
        <div id="tabContainer" class="grid grid-cols-1 gap-6">
            {{-- My Profile --}}
            <section id="profile" class="tabContent border border-slate-300 rounded px-4 pt-2 pb-4">
                <h3 class="font-medium text-lg text-gray-900">Personal Information</h3>
                <hr>
            
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            
                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">First Name</label>
                        <input class="mt-2 px-3 bg-transparent focus:outline-none w-full" type="text" name="" id="name"
                            value="Shubham">
                    </div>
            
                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Last Name</label>
                        <input class="mt-2 px-3 bg-transparent focus:outline-none w-full" type="text" name="" id="name"
                            value="kumar">
                    </div>
                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Mobile Number</label>
                        <input class="mt-2 px-3 bg-transparent focus:outline-none w-full" type="text" name="" id="name"
                            value="1234567890">
                    </div>
                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Email Adddress</label>
                        <input class="mt-2 px-3 bg-transparent focus:outline-none w-full" type="email" name="" id="name"
                            value="shubham@gmail.com">
                    </div>
                    <div></div>
                    <div>
                        <button
                            class="bg-violet-600 rounded py-1 text-center w-full shoadow text-white uppercase font-medium">Update</button>
                    </div>
                </div>
            </section>
            {{-- My Profile End--}}
            
            
            {{-- My Orders --}}
            <section id="orders" class="tabContent hidden border border-slate-300 rounded px-4 pt-2 pb-4">
                <h3 class="font-medium text-lg text-gray-900">My Orders </h3>
                <hr class="mb-4">
            
            
                <div class="grid grid-cols-1 gap-6">
            
                    <div class="flex flex-col md:flex-row justify-between ">
                        <div>
                            <div class="mb-1 flex flex-wrap gap-3">
                                @foreach (range(1,4) as $item)
                                <div class="bg-gray-100 rounded shadow p-2">
                                    <img class="w-20" src="{{asset('images/product-1.png')}}" alt="">
                                </div>
                                @endforeach
                            </div>
                            <div class="grid  md:grid-cols-4 gap-4">
                                <div class="flex flex-col  text-gray-800 leading-5">
                                    <span class="font-medium">Order ID</span>
                                    <span>3242342342</span>
                                </div>
            
                                <div class="flex flex-col  text-gray-800 leading-5">
                                    <span class="font-medium">Shipped Date</span>
                                    <span>03,Dec,2023</span>
                                </div>
            
                                <div class="flex flex-col  text-gray-800 leading-5">
                                    <span class="font-medium">Total</span>
                                    <span>$ 15000</span>
                                </div>
            
                                <div class="flex flex-col leading-5">
                                    <span class="font-medium text-gray-800">Status</span>
                                    <span class="font-medium text-green-500">Deliver</span>
                                </div>
                            </div>
                        </div>
            
                        <div class="shrink-0 flex flex-col gap-2 my-2">
                            <button class="border borde-slate-400 text-black font-medium uppercase px-4 rounded-sm">View
                                Order</button>
                            {{-- <button
                                class="hover:border-slate-500 my-1 py-1 hover:border rounded text-red-500 font-medium uppercase px-4">Cancel
                                Order</button> --}}
                        </div>
                    </div>
                    <hr>
                    <div class="flex flex-col md:flex-row justify-between">
                        <div class="">
                            {{-- <div></div> --}}
                            <div class="mb-1 flex flex-wrap gap-3">
                                @foreach (range(1,1) as $item)
                                <div class="bg-gray-100 rounded shadow p-2">
                                    <img class="w-20" src="{{asset('images/product-1.png')}}" alt="">
                                </div>
                                @endforeach
                            </div>
                            <div class="grid md:grid-cols-4 gap-4">
                                <div class="flex flex-col  text-gray-800 leading-5">
                                    <span class="font-medium">Order ID</span>
                                    <span>3242342342</span>
                                </div>
            
                                <div class="flex flex-col  text-gray-800 leading-5">
                                    <span class="font-medium">Shipped Date</span>
                                    <span>03,Dec,2023</span>
                                </div>
            
                                <div class="flex flex-col  text-gray-800 leading-5">
                                    <span class="font-medium">Total</span>
                                    <span>$ 15000</span>
                                </div>
            
                                <div class="flex flex-col leading-5">
                                    <span class="font-medium text-gray-800">Status</span>
                                    <span class="font-medium text-green-500">Processing</span>
                                </div>
                            </div>
                        </div>
            
            
                        <div class="shrink-0 flex flex-col gap-2 my-2">
                            <button class="border borde-slate-400 text-black font-medium uppercase px-4 rounded-sm">View
                                Order</button>
                            <button
                                class="hover:border-slate-500 my-1 py-1 hover:border rounded text-red-500 font-medium uppercase px-4">Cancel
                                Order</button>
                        </div>
                    </div>
                    <hr>
                    <div class="flex flex-col md:flex-row justify-between ">
                        <div class="">
                            {{-- <div></div> --}}
                            <div class="mb-1 flex flex-wrap gap-3">
                                @foreach (range(1,4) as $item)
                                <div class="bg-gray-100 rounded shadow p-2">
                                    <img class="w-20" src="{{asset('images/product-1.png')}}" alt="">
                                </div>
                                @endforeach
                            </div>
                            <div class="grid md:grid-cols-4 gap-4">
                                <div class="flex flex-col  text-gray-800 leading-5">
                                    <span class="font-medium">Order ID</span>
                                    <span>3242342342</span>
                                </div>
            
                                <div class="flex flex-col  text-gray-800 leading-5">
                                    <span class="font-medium">Shipped Date</span>
                                    <span>03,Dec,2023</span>
                                </div>
            
                                <div class="flex flex-col  text-gray-800 leading-5">
                                    <span class="font-medium">Total</span>
                                    <span>$ 15000</span>
                                </div>
            
                                <div class="flex flex-col leading-5 ">
                                    <span class="font-medium text-gray-800">Status</span>
                                    <span class="font-medium text-green-500">Out For Deliver</span>
                                </div>
                            </div>
                        </div>
            
            
                        <div class="shrink-0 flex flex-col gap-2 my-2">
                            <button class="border borde-slate-400 text-black font-medium uppercase px-4 rounded-sm">Track
                                order</button>
                            <button
                                class="hover:border-slate-500 my-1 py-1 hover:border rounded text-red-500 font-medium uppercase px-4">Cancel
                                Order</button>
                        </div>
                    </div>
                </div>
            
            </section>
            {{-- My Orders End--}}
            
            {{-- My Delivery Addresses --}}
            <section id="address" class="tabContent hidden border border-slate-300 rounded px-4 pt-2 pb-4">
                <h3 class="font-medium text-lg text-gray-900">My Delivery Addresses</h3>
                <hr>
            
                <div class="grid grid-cols-1 md:grid-cols-3  gap-4 mt-4">
                    @foreach (range(1,4) as $loop)
                    <div class="p-2 rounded shadow bg-gray-100">
                        <div class="flex justify-between items-center">
                            <p class="text-gray-800 font-medium hover:text-violet-600 duration-300 cursor-pointer">
                                Shubham kumar <small>(Home address)</small>
                            </p>
                            <i class="bx bx-pencil">Edit</i>
                        </div>
                        <p class="text-gray-600">Varanasi, Saranath ,UttarPradesh</p>
                        <p class="text-gray-600">Mobile No : +91 1234567890</p>
                    </div>
                    @endforeach
                    <div class="flex flex-col py-6 items-center justify-center p-2 rounded shadow bg-gray-100">
                        <i class="bx bxs-plus-circle text-gray-800"></i>
                        <p class="text-gray-400 text-2xl">Add New Address</p>
                    </div>
                </div>
            </section>
            {{-- My Delivery Addresses End--}}
        </div>
    </div>
    {{-- Right Side End --}}
</div>
@endsection