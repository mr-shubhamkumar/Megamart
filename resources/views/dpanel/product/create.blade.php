@extends('dpanel.layouts.app')
@section('title', 'Products')
@section('body_content')

<div class="bg-gray-800 flex justify-between items-center rounded-l pl-2 mb-3 p-2">
    <p class="text-white font-medium text-lg">Products Creat</p>
    <a href="{{ route('dpanel.product.index')}}" class="bg-violet-500 py-1 px-2 rounded">Back</a>
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



<div class="w-full "></div>
@endsection