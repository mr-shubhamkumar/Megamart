@extends('dpanel.layouts.app')
@section('title', 'Create New Products')

@push('scripts')
    <script>

        const addVariant = (e) => {
            let colorOptions = '<option value="">select</option>';
            let sizeOptions = '<option value="">select</option>';



            let html = `<div class="flex justify-between gap-3 mb-2 border-b border-gray-400 pb-2">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    <div>
                        <label class="text-white"> Color</label>
                        <select name="color_id" class="w-full  border border-gray-700 rounded py-0.5 focus:outline-none">
                            ${colorOptions}
                        </select>
                    </div>
                    <div>
                        <label class="text-white"> Size</label>
                        <select name="size_id" class="w-full  border border-gray-700 rounded py-0.5 focus:outline-none">
                            ${sizeOptions}
                        </select>
                    </div>

                    <div>
                        <label class="text-white">MRP / Unit</label>
                        <input type="number" name="mrp" placeholder="Enter Product MRP"
                            class="w-full px-2 border  rounded py-0.5 focus:outline-none">
                    </div>

                    <div>
                        <label class="text-white">Price / Unit</label>
                        <input type="number" name="selling_price" placeholder="Enter Product Price"
                            class="w-full px-2 border  rounded py-0.5 focus:outline-none">
                    </div>
                    <div>
                        <label class="text-white">Stock </label>
                        <input type="number" name="stock" placeholder="Enter Available Stock"
                            class="w-full px-2 border  rounded py-0.5 focus:outline-none">
                    </div>

                </div>


                <div class="flex items-end">
                    <button type="button" onclick="addVariant(this)"
                            class="bg-indigo-500 text-center w-16 py-1 rounded text-white">Add</button>
                </div>
            </div>`;

            e.parentElement.innerHTML = `<button type="button" onclick="removeVariant(this)" class="bg-red-500 border text-center w-16 py-1 rounded text-white">Remove</button>`;

            document.getElementById('product_variants').lastElementChild.insertAdjacentHTML('afterend', html);
        }

        const removeVariant = e => e.parentElement.parentElement.remove()
    </script>
@endpush
@section('body_content')

    <div class="bg-gray-800 flex justify-between items-center rounded-l pl-2 mb-3 p-2">
        <p class="text-white font-medium text-lg">Products Creat</p>
        <a href="{{ route('dpanel.product.index') }}" class="bg-violet-500 py-1 px-2 rounded">Back</a>
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



    <div class="w-full ">
        <form action="{{ route('dpanel.product.store') }}" method="post" enctype="multipart/form-data">
            @csrf


            <section>
                <h2 class="mb-2 text-lg">Product Basic Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-y-2 gap-x-4 bg-gray-800 p-2 ">
                    <div>
                        <label class="text-white">Product Category</label>
                        <select name="category_id" class="w-full border border-gray-700 rounded py-0.5 focus:outline-none">
                            <option value="">select</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-white">Product Brand</label>
                        <select name="brand_id" class="w-full  border border-gray-700 rounded py-0.5 focus:outline-none">
                            <option value="">select</option>
                            @foreach ($brands as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-white">Product Name / Title</label>
                        <input type="text" name="title" placeholder="Enter Product Title"
                            class="w-full px-2 border  rounded py-0.5 focus:outline-none">
                    </div>
                    <div class="md:col-span-3">
                        <label class="text-white">Product Description </label>
                        <textarea name="description" rows="3" placeholder="Enter description"
                            class="w-full px-2 border  rounded py-0.5 focus:outline-none"></textarea>

                    </div>
                </div>
            </section>


            <section id="product_variants" class="bg-gray-800 px-3 rounded mb-3 mt-2">
                <h2 class="mb-2 text-lg text-white">Product Variants</h2>

                <div class="flex justify-between gap-3 mb-2 border-b border-gray-400 pb-2">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                        <div>
                            <label class="text-white"> Color</label>
                            <select name="color_id"
                                class="w-full  border border-gray-700 rounded py-0.5 focus:outline-none">
                                <option value="">select</option>
                                @foreach ($color as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-white"> Size</label>
                            <select name="size_id" class="w-full  border border-gray-700 rounded py-0.5 focus:outline-none">
                                <option value="">select</option>
                                @foreach ($size as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-white">MRP / Unit</label>
                            <input type="number" name="mrp" placeholder="Enter Product MRP"
                                class="w-full px-2 border  rounded py-0.5 focus:outline-none">
                        </div>

                        <div>
                            <label class="text-white">Price / Unit</label>
                            <input type="number" name="selling_price" placeholder="Enter Product Price"
                                class="w-full px-2 border  rounded py-0.5 focus:outline-none">
                        </div>
                        <div>
                            <label class="text-white">Stock </label>
                            <input type="number" name="stock" placeholder="Enter Available Stock"
                                class="w-full px-2 border  rounded py-0.5 focus:outline-none">
                        </div>

                    </div>


                    <div class="flex items-end">
                        <button type="button" onclick="addVariant(this)"
                            class="bg-indigo-500 text-center w-16 py-1 rounded text-white">Add</button>
                    </div>
                </div>
            </section>

            <button class="text-black">Submit</button>
        </form>
    </div>
@endsection
