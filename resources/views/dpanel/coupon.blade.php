
@extends('dpanel.layouts.app')
@section('title', 'Coupon')
@push('scripts')
    <script>

        editCoupon = (item ,form,till) =>{
            item = JSON.parse(item);
            console.log(item)
            document.getElementById("edit-form").action =`${window.location.href}/${item.id}`;
            document.getElementById('code').value = item.code;
            document.getElementById('type').value = item.type;
            document.getElementById('value').value = item.value;
            document.getElementById('min_cart_amount').value = item.min_cart_amount;
            document.getElementById('from_valid').value = form;
            document.getElementById('till_valid').value = till;
            var show = 'bottomSheetUpdate'
            showBottomSheet(show);
        }
    </script>

@endpush

@section('body_content')

    <div class="bg-gray-800 flex justify-between items-center rounded-l pl-2 mb-3 p-2">
        <p class="text-white font-medium text-lg">Coupon</p>
        <button onclick="showBottomSheet('bottomSheet')" class="bg-violet-500 py-1 px-2 rounded">Create</button>
    </div>

    @if ($errors->any())
        <div class="bg-red text-red-500 px-2 py-1 rounded border border-red-500 mb-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- <Table></Table> --}}
    {{-- list data  --}}
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Code
                </th>
                <th scope="col" class="px-6 py-3">
                    Type
                </th>
                <th scope="col" class="px-6 py-3">
                    Value
                </th>
                <th scope="col" class="px-6 py-3">
                    Min Cart Amount
                </th>
                <th scope="col" class="px-6 py-3">
                    From Valid
                </th>

                    <th scope="col" class="px-6 py-3">
                        Till Valid
                    </th>

                <th scope="col" class="px-6 py-3">
                    ACTION
                </th>

            </tr>
            </thead>
            <tbody>
            @foreach ($data as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                    <td class="px-6 py-4">
                        <div class="sm to-gray-200">
                            {{$data->perpage() * ($data->currentPage() - 1) + $loop-> iteration}}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-200">{{ $item->code }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-200">{{ $item->type }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-200">{{ $item->value }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-200">{{ $item->min_cart_amount ? $item->min_cart_amount:'N/A' }}</div>
                    </td>

                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-200">{{ $item->from_valid->format('d-m-Y h:i A') }}</div>
                        </td>

                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-200">{{ $item->till_valid ? $item->till_valid->format('d-m-Y h:i A'): '' }}</div>
                    </td>



                    <td class="px-6 py-4 text-left">
                        <button onclick="editCoupon('{{ $item }}', '{{ $item->from_valid->format('Y-m-d\TH:i') }}','{{ $item->till_valid ? $item->till_valid->format('Y-m-d\TH:i'): null }}')" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        {{$data->links()}}
    </div>
    {{-- list data --}}
    {{-- creat data --}}
    <x-dpanel::modal.bottom-sheet sheetId="bottomSheet" title="New Coupon">
        <div class="flex border justify-center items-center min-h-[30vh] md:min-h-[50vh]">
            <form action="{{route('dpanel.coupon.store')}}" method="post">
                @csrf
                <div class=" grid grid-cols-1 gap-3">
                    <div>
                        <label for="">Coupon Code</label>
                        <input type="text" name="code" maxlength="50" required placeholder="Enter Coupon Code
                    " class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                    </div>
                    <div>
                        <label for="">Coupon Type</label>
                        <select name="type" ss="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                            <option value="">Select Type</option>
                            <option value="Fixed">Fixed</option>
                            <option value="Percentage">Percentage</option>
                        </select>
                    </div>
                    <div>
                        <label for="">Coupon Value</label>
                        <input type="number" name="value"  required placeholder="Enter Coupon Value
                    " class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                    </div>
                    <div>
                        <label>Min Cart Amount</label>
                        <input type="number" name="min_cart_amount" placeholder="Enter Min Cart Amount"
                            class="w-full bg-transparent border border-gray-500 rounded py-0.5 px-2 focus:outline-none">
                    </div>
                    <div>
                        <label>Valid From<span class="text-red-500 font-bold">*</span></label>
                        <input type="datetime-local" name="from_valid" 
                            class="w-full bg-transparent border border-gray-500 rounded py-0.5 px-2 focus:outline-none">
                    </div>
                    <div>
                        <label>Valid To<span class="text-red-500 font-bold">*</span></label>
                        <input type="datetime-local" name="till_valid"
                            class="w-full bg-transparent border border-gray-500 rounded py-0.5 px-2 focus:outline-none">
                    </div>
                    <div class="text-center ">
                        <button class="bg-violet-500 text-center text-white py-1 px-2 rounded shadow-md uppercase">Add New Coupon</button>
                    </div>
                </div>
            </form>
        </div>
    </x-dpanel::modal.bottom-sheet>
    {{-- creat data end --}}

    {{-- udate data --}}
    <x-dpanel::modal.bottom-sheet sheetId="bottomSheetUpdate" title="Update Category">
        <div class="flex border justify-center items-center min-h-[30vh] md:min-h-[50vh]">
            <form id="edit-form" action="" method="post">
                @csrf
                @method('PUT')
                <div class=" grid grid-cols-1 gap-3">
                    <div>
                        <label for="">Coupon Code</label>
                        <input type="text" name="code" id="code" maxlength="50" required placeholder="Enter Coupon Code
                    " class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                    </div>
                    <div>
                        <label for="">Coupon Type</label>
                        <select name="type" id="type" class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                            <option value="">Select Type</option>
                            <option value="Fixed">Fixed</option>
                            <option value="Percentage">Percentage</option>
                        </select>
                    </div>
                    <div>
                        <label for="">Coupon Value</label>
                        <input type="number" name="value"  id="value" required placeholder="Enter Coupon Value
                    " class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                    </div>
                    <div>
                        <label for="">Min Cart Amount</label>
                        <input type="number" name="min_cart_amount" id="min_cart_amount"  placeholder="Enter Min Cart Amount
                    " class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                    </div>
                    <div>
                        <label for="">Valid Form </label>
                        <input type="datetime-local" name="from_valid" id="from_valid"
                               class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                    </div>

                    <div>
                        <label for="">Valid  </label>
                        <input type="datetime-local" name="till_valid" id="till_valid"
                               class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                    </div>
                    <div class="text-center ">
                        <button class="bg-violet-500 text-center text-white py-1 px-2 rounded shadow-md uppercase">Update Coupon</button>
                    </div>
                </div>
            </form>
        </div>
    </x-dpanel::modal.bottom-sheet>


    <x-dpanel::modal.bottom-sheet-js hideOnClickOutside="true" />
@endsection
