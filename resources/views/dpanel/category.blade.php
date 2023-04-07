@extends('dpanel.layouts.app')
@section('title', 'Category')
@push('scripts')
    <script>

         editCategory = (id,name,status) =>{
            document.getElementById("edit-form").action = '/dpanel/category/' + id;
            document.getElementById('category-name').value = name;
            document.getElementById('category-status').value = status;
            var show = 'bottomSheetUpdate'
            showBottomSheet(show);
        }
    </script>

@endpush

@section('body_content')

<div class="bg-gray-800 flex justify-between items-center rounded-l pl-2 mb-3 p-2">
    <p class="text-white font-medium text-lg">Category</p>
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
                    name
                </th>
                <th scope="col" class="px-6 py-3">
                    STATUS
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
                        <div class="text-sm text-gray-200">{{ $item->name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-200">{{ $item->is_active ? 'Active':"Not Active" }}</div>
                    </td>
                
                    <td class="px-6 py-4 text-left">
                        <button onclick="editCategory('{{ $item->id}}', '{{ $item->name}}','{{$item->is_active}}')" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</button>
                    </td>
                </tr>
          @endforeach
           
        </tbody>
    </table>
    {{$data->links()}}
</div>
{{-- list data --}}
{{-- creat data --}}
<x-dpanel::modal.bottom-sheet sheetId="bottomSheet" title="New Category">
    <div class="flex border justify-center items-center min-h-[30vh] md:min-h-[50vh]">
        <form action="{{route('dpanel.category.store')}}" method="post">
            @csrf
            <div class=" grid grid-cols-1 gap-3">
                <div>
                    <label for="">Name</label>
                    <input type="text" name="name" maxlength="255" required placeholder="Enter Category Name
                    " class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                </div>
              
                <div class="text-center ">
                    <button class="bg-violet-500 text-center text-white py-1 px-2 rounded shadow-md uppercase">New Category</button>
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
                {{-- <input type="hidden" name="id" value=""> --}}
                <div>
                    <label for="">Name</label>
                    <input type="text" name="name" id="category-name" maxlength="255" required placeholder="Enter Category Name
                    " class="w-full bg-transparent border border-gray-500 rounded px-2 focus:outline-none">
                </div>
              <div>
                <label for="">Catagory Status</label>
                <select name="is_active" id="category-status">
                    <option value="1">Active</option>
                    <option value="0">Not Active</option>
                </select>
              </div>
                <div class="text-center ">
                    <button class="bg-violet-500 text-center text-white py-1 px-2 rounded shadow-md uppercase">Update Category</button>
                </div>
            </div>
        </form>
    </div>
</x-dpanel::modal.bottom-sheet>


<x-dpanel::modal.bottom-sheet-js hideOnClickOutside="true" />
@endsection