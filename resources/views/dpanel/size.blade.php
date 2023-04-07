@extends('dpanel.layouts.app')
@section('title', 'Sizes')
@push('scripts')
<script>
    editSize = (id,name,code,status) =>{
            document.getElementById("edit-form").action = '/dpanel/size/' + id;
            document.getElementById('size-name').value = name;
            document.getElementById('size-code').value = code;
            document.getElementById('size-status').value = status;
            var show = 'bottomSheetUpdate'
            showBottomSheet(show);
        }
</script>

@endpush

@section('body_content')

<div class="bg-gray-800 flex justify-between items-center rounded-l pl-2 mb-3 p-2">
    <p class="text-white font-medium text-lg">Sizes</p>
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
{{-- list data --}}
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Code
                </th>
                <th scope="col" class="px-6 py-3">
                Status
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
                        {{$item->id}}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-200">{{ $item->name }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-200">{{ $item->code }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-200">{{ $item->is_active ? 'Active':"Not Active" }}</div>
                </td>

                <td class="px-6 py-4 text-left">
                    <button onclick="editSize('{{ $item->id}}', '{{ $item->name}}','{{ $item->code}}','{{$item->is_active}}')"
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    
</div>
{{-- list data --}}
{{-- creat data --}}
<x-dpanel::modal.bottom-sheet sheetId="bottomSheet" title="New size">
    <div class="flex border justify-center items-center min-h-[30vh] md:min-h-[50vh]">
        <form action="{{route('dpanel.size.store')}}" method="post">
            @csrf
            <div class=" grid grid-cols-1 gap-3">
                <div>
                    <label for="">Size Name</label>
                    <input type="text" name="name" maxlength="255" required placeholder="Enter size Name
                    " class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                </div>
                <div>
                    <label for="">Size Code</label>
                    <input type="text" name="code" maxlength="255" required placeholder="Enter size Name
                    " class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                </div>

                <div class="text-center ">
                    <button class="bg-violet-500 text-center text-white py-1 px-2 rounded shadow-md uppercase">New
                        size</button>
                </div>
            </div>
        </form>
    </div>
</x-dpanel::modal.bottom-sheet>
{{-- creat data end --}}

{{-- udate data --}}
<x-dpanel::modal.bottom-sheet sheetId="bottomSheetUpdate" title="Update size">
    <div class="flex border justify-center items-center min-h-[30vh] md:min-h-[50vh]">
        <form id="edit-form" action="" method="post">
            @csrf
            @method('PUT')
            <div class=" grid grid-cols-1 gap-3">
                {{-- <input type="hidden" name="id" value=""> --}}
                <div>
                    <label for="">Name</label>
                    <input type="text" name="name" id="size-name" maxlength="255" required placeholder="Enter size Name
                    " class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                </div>
                <div>
                    <label for="">Code</label>
                    <input type="text" name="code" id="size-code" maxlength="255" required placeholder="Enter size Name
                    " class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                </div>
                <div>
                    <label for="">Catagory Status</label>
                    <select name="is_active" id="size-status">
                        <option value="1">Active</option>
                        <option value="0">Not Active</option>
                    </select>
                </div>
                <div class="text-center ">
                    <button class="bg-violet-500 text-center text-white py-1 px-2 rounded shadow-md uppercase">Update
                        size</button>
                </div>
            </div>
        </form>
    </div>
</x-dpanel::modal.bottom-sheet>


<x-dpanel::modal.bottom-sheet-js hideOnClickOutside="true" />
@endsection