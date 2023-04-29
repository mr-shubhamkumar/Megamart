@extends('layouts.app')
@push('scripts')
    <script>
        const getDistrictStateByPinCode = (e, district = null,state = null) => {
            console.log(e.value);
            var pincode = e.value;
            let calledApi = false;
            if (calledApi) return;

            let _district = document.getElementById('district')
            let _state = document.getElementById('state')
            let piccode = typeof e === 'string'? e : e.value;

            if (piccode.length == 6) {
                calledApi = true;
                fetch(`https://api.postalpincode.in/pincode/${piccode}`)
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
                                _district.innerHTML = `<option value="${distItems[0]}">${distItems[0]}</option>`
                            } else {
                                let html = '<option value="">select</option>';
                                distItems.forEach(element => {
                                    html += `<option value="${element}" ${element==district?'selected':''}>${element}</option>`
                                });
                                _district.innerHTML = html;
                            }
                            if (stateItems.length == 1) {
                                _state.innerHTML = `<option value="${stateItems[0]}">${stateItems[0]}</option>`
                            } else {
                                let html = '<option value="">select</option>';
                                stateItems.forEach(element => {
                                    html += `<option value="${element}"${element==state?'selected':''}>${element}</option>`
                                });
                                _state.innerHTML = html;
                            }

                        } else {
                            toast.error(data.Massage);
                        }
                    })
            }
        };

     @auth
     @if($data->pin_code)
             getDistrictStateByPinCode("{{ $data->pin_code }}", "{{ $data->district }}","{{ $data->state}}");
        @endif
     @endauth
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
          @auth
          <section id="profile" class="tabContent border border-slate-300 rounded px-4 pt-2 pb-4">
            <h3 class="font-medium text-lg text-gray-900 font-medium text-center">Edit Delivery Address</h3>
            <hr>

            <form action="{{ route('address.update',$data->id)}}" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                @method('PUT')

                <div class="mt-4  relative border border-slate-300 rounded">
                    <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Default
                        Address</label>
                    <select name="is_default_address" class="mt-2 px-3 bg-transparent focus:outline-none w-full"
                        required>
                        <option value="">Select</option>
                        <option value="1" @selected( $data->is_default_address=1)>Yes</option>
                        <option value="0" @selected( $data->is_default_address=0)>No</option>
                    </select>
                </div>
                <div class="mt-4  relative border border-slate-300 rounded">
                    <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Tag</label>
                    <select name="tag" class="mt-2 px-3 bg-transparent focus:outline-none w-full" required>
                        <option value="">Select</option>
                        <option value="Home" @selected( $data->tag=1)>Home</option>
                        <option value="Office" @selected( $data->tag=0)>Office</option>
                    </select>
                </div>

                <div class="mt-4  relative border border-slate-300 rounded">
                    <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">First
                        Name</label>
                    <input class="mt-2 px-3 bg-transparent focus:outline-none w-full" type="text" name="first_name"
                       value="{{ $data->first_name }}" required>
                </div>

                <div class="mt-4  relative border border-slate-300 rounded">
                    <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Last Name</label>
                    <input class="mt-2 px-3 bg-transparent focus:outline-none w-full" type="text" name="last_name"
                           value="{{ $data->last_name }}" required>
                </div>
                <div class="mt-4  relative border border-slate-300 rounded">
                    <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Mobile
                        Number</label>
                    <input class="mt-2 px-3 bg-transparent focus:outline-none w-full" type="tel" maxlength="10"
                        name="mobile_no" value="{{ $data->mobile_no }}" required>
                </div>

                <div class="mt-4  relative border border-slate-300 rounded">
                    <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Street
                        Address</label>
                    <input class="mt-2 px-3 bg-transparent focus:outline-none w-full" type="text"
                        name="street_address" value="{{ $data->street_address }}" required>
                </div>

                <div class="mt-4  relative border border-slate-300 rounded">
                    <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">Pin code</label>
                    <input type="tel" maxlength="6" name="pin_code" onkeyup="getDistrictStateByPinCode(this)"
                        class="mt-2 px-3 bg-transparent focus:outline-none w-full" value="{{ $data->pin_code }}" required>
                </div>

                <div class="mt-4  relative border border-slate-300 rounded">
                    <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">district</label>
                    <select name="district" id="district"  class="mt-2 px-3 bg-transparent focus:outline-none w-full"
                        required>

                    </select>
                </div>
                <div class="mt-4  relative border border-slate-300 rounded">
                    <label for="" class="absolute -top-3 left-3.5 bg-white px-1 text-gray-400">State</label>
                    <select name="state" id="state"  class="mt-2 px-3 bg-transparent focus:outline-none w-full"
                        required>

                    </select>
                </div>




                <div>
                    <label>&nbsp;</label>
                    <button
                        class="bg-violet-600  rounded py-1 text-center w-full shoadow text-white uppercase font-medium">
                        Update
                    </button>
                </div>

            </form>
        </section>
        @else
        <div class="border w-full py-10 mt-3 flex justify-center rounded-md items-center">
            <button type="button" class="text-violet-500 font-medium" onclick="toggleLoginPopup()">Login
                to Access Your Acount</button>
        </div>
          @endauth
        </div>
    </div>
@endsection
