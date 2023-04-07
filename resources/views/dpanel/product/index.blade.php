@extends('dpanel.layouts.app')
@section('title', 'Products')
@section('body_content')

<div class="bg-gray-800 flex justify-between items-center rounded-l pl-2 mb-3 p-2">
    <p class="text-white font-medium text-lg">Products</p>
    <a href="{{ route('dpanel.product.create')}}"  class="bg-violet-500 py-1 px-2 rounded">Create</a>
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

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    #
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Brand
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
                       {{ $data->perPage() * ($data->currentPage() - 1) + $loop->iteration}}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-200">{{ $item->category->name }}</div>
                    {{-- {{ $item->category->name }}  --}}
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-200">{{ $item->title }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-200">{{$item->brand->name}}</div>
                </td>

                <td class="px-6 py-4 text-left">
                    <a href="{{route('dpanel.product.edit',$item->id)}}"

                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

</div>
@endsection
