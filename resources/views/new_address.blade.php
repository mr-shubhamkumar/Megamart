@extends('layouts.app')
@push('scripts')
    <script>
        const getDistrictStateByPinCode = (e) => {
            console.log(e.value);
            var pincode = e.value;
            let calledApi = false;
            if (calledApi) return;

            let district = document.getElementById('district')
            let state = document.getElementById('state')

            if (e.value.length == 6) {
                calledApi = true;
                fetch(`https://api.postalpincode.in/pincode/${e.value}`)
                    .then((response) => response.json())
                    .then((data) => {
                        data = data[0];
                        console.log(data);
                        if (data.Status == 'Success') {
                            var distItems = [];
                            var stateItems = [];
                            data.PostOffice.forEach(ele => {
                                if (distItems.indexOf(ele.District) === -1) distItems.push(ele.District)
                                if (stateItems.indexOf(ele.State) === -1) stateItems.push(ele.State)
                            });

                            if (distItems.length == 1) {
                                district.innerHTML = `<option value="${distItems[0]}">${distItems[0]}</option>`
                            } else {
                                let html = '<option value="">select</option>';
                                distItems.forEach(element => {
                                    html += `<option value="${element}">${element}</option>`
                                });
                                district.innerHTML = html;
                            }
                            if (stateItems.length == 1) {
                                state.innerHTML = `<option value="${stateItems[0]}">${stateItems[0]}</option>`
                            } else {
                                let html = '<option value="">select</option>';
                                stateItems.forEach(element => {
                                    html += `<option value="${element}">${element}</option>`
                                });
                                state.innerHTML = html;
                            }

                        } else {
                            toast.error(data.Massage);
                        }
                    })
            }
        };
    </script>
@endpush

@section('boby_content')
    <div class="px-6 md:px-20 md:min-h-screen grid grid-cols-1 md:gap-2 md:grid-cols-6 gap-4">
        <div class="">
            <ul id="tabLink" class="flex md:flex-col flex-wrap justify-between gap-3">
                <li><a class="flex" href="{{ route('account.index') }}"> My Profile</a></li>
                <li><a class="flex" href="{{ route('account.index', ['tab' => 'orders']) }}"> My Orders</a></li>
                <li><a class="flex text-violet-500 underline" href="{{ route('account.index', ['tab' => 'address']) }}">
                        My Address</a></li>
                <li><a href="{{ route('logout') }}" class="flex">Logout</a></li>
            </ul>
        </div>
        <div class="md:col-span-5">
            <section id="profile" class="tabContent border border-slate-300 rounded px-4 pt-2 pb-4">
                <h3 class="font-medium text-lg text-gray-900 font-medium text-center">New Delivery Address</h3>
                <hr>

                <form action="{{ route('address.store')}}" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @csrf

                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Default
                            Address</label>
                        <select name="is_default_address" class="mt-2 px-3 bg-transparent focus:outline-none w-full"
                            required>
                            <option value="">Select</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Tag</label>
                        <select name="tag" class="mt-2 px-3 bg-transparent focus:outline-none w-full" required>
                            <option value="">Select</option>
                            <option value="Home">Home</option>
                            <option value="Office">Office</option>
                        </select>
                    </div>

                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">First
                            Name</label>
                        <input class="mt-2 px-3 bg-transparent focus:outline-none w-full" type="text" name="first_name"
                            required>
                    </div>

                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Last Name</label>
                        <input class="mt-2 px-3 bg-transparent focus:outline-none w-full" type="text" name="last_name"
                            required>
                    </div>
                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Mobile
                            Number</label>
                        <input class="mt-2 px-3 bg-transparent focus:outline-none w-full" type="tel" maxlength="10"
                            name="mobile_no" required>
                    </div>

                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Street
                            Address</label>
                        <input class="mt-2 px-3 bg-transparent focus:outline-none w-full" type="text"
                            name="street_address" required>
                    </div>

                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Pin code</label>
                        <input type="tel" maxlength="6" name="pin_code" onkeyup="getDistrictStateByPinCode(this)"
                            class="mt-2 px-3 bg-transparent focus:outline-none w-full" required>
                    </div>

                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">district</label>
                        <select name="district" id="district" class="mt-2 px-3 bg-transparent focus:outline-none w-full"
                            required>

                        </select>
                    </div>
                    <div class="mt-4  relative border border-slate-300 rounded">
                        <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">State</label>
                        <select name="state" id="state" class="mt-2 px-3 bg-transparent focus:outline-none w-full"
                            required>

                        </select>
                    </div>




                    <div>
                        <label>&nbsp;</label>
                        <button
                            class="bg-violet-600  rounded py-1 text-center w-full shoadow text-white uppercase font-medium">
                            Save
                        </button>
                    </div>

                </form>
            </section>
        </div>
    </div>
@endsection
