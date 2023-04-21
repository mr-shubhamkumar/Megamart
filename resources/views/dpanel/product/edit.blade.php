@extends('dpanel.layouts.app')
@section('title', 'Edit  Products')

@push('scripts')
    <script>
        const addVariant = (e, addRemoveButton=true) => {
            let colorOptions = '<option value="">select</option>';
            let sizeOptions = '<option value="">select</option>';


            let colors = @json($color);
            colors.forEach(color => {

                colorOptions += `<option value="${ color . id }">${ color . name }</option>`;
            });

            let size = @json($size);
            size.forEach(size => {

                sizeOptions += `<option value="${ size . id }">${ size . name }</option>`;
            });


            let html = `<div class="flex justify-between gap-3 mb-2 border-b border-gray-400 pb-2">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    <div>
                        <label class="text-white"> Color</label>
                        <select name="color_id[]" class="w-full  border border-gray-700 rounded py-0.5 focus:outline-none" required>
                            ${colorOptions}
                        </select>
                    </div>
                    <div>
                        <label class="text-white"> Size</label>
                        <select name="size_id[]" class="w-full  border border-gray-700 rounded py-0.5 focus:outline-none" required>
                            ${sizeOptions}
                        </select>
                    </div>

                    <div>
                        <label class="text-white">MRP / Unit</label>
                        <input type="number" name="mrp[]" placeholder="Enter Product MRP"
                            class="w-full px-2 border  rounded py-0.5 focus:outline-none" required>
                    </div>

                    <div>
                        <label class="text-white">Price / Unit</label>
                        <input type="number" name="selling_price[]" placeholder="Enter Product Price"
                            class="w-full px-2 border  rounded py-0.5 focus:outline-none" required>
                    </div>
                    <div>
                        <label class="text-white">Stock </label>
                        <input type="number" name="stock[]" placeholder="Enter Available Stock"
                            class="w-full px-2 border  rounded py-0.5 focus:outline-none" required>
                    </div>

                </div>


                <div class="flex items-end">
                    <button type="button" onclick="addVariant(this)"
                            class="bg-indigo-500 text-center w-16 py-1 rounded text-white">Add</button>
                </div>
            </div>`;

            if (addRemoveButton){

            e.parentElement.innerHTML =
                `<button type="button" onclick="removeVariant(this)" class="bg-red-500 border text-center w-16 py-1 rounded text-white">Remove</button>`;
            }else {
                e.parentElement.parentElement.remove();
            }


            document.getElementById('product_variants').lastElementChild.insertAdjacentHTML('afterend', html);
        }


        //Image Input

        const  addMoreImage = () => {
            let id = 'img-' + Math.floor(Math.random() * 10000);
            let html = `<div class="relative">
                        <label for="${id}" class="flex items-center justify-center rounded-md shadow cursor-pointer">
                            <input type="file" name="images[]" id="${id}" onchange="setImagePreview(this, event)"
                                accept="image/*" class="hidden" >
                            <img src="https://placehold.jp/400x600.png?text=Add%20Image"
                                class="rounded-md aspect-[2/3] object-cover" alt="">
                        </label>
                    </div>`;
            document.getElementById('image_container').lastElementChild.insertAdjacentHTML('afterend', html)
        }

        const setImagePreview = (r,e,isAdd = true) => {
            if(e.target.files.length > 0){
                r.setAttribute('onchange', 'setImagePreview(this, event,false)');
                r.nextElementSibling.src = URL.createObjectURL(e.target.files[0]);

                let span = `<span onclick='deleteImage(this)' class="absolute top-1 right-1 cursor-pointer w-7 h-7 flex items-center justify-center bg-white hover:bg-red-500 bg-opacity hover:bg-opacity-100 hover:text-white duration-300 shodow rounded-full">
                    <i class='bx bxs-trash'></i>
                    </span>`;

                r.parentElement.insertAdjacentHTML('afterend',span);

                if (isAdd) addMoreImage();
            }
        }

        const removeVariant = e => e.parentElement.parentElement.remove();
        const deleteImage = e => e.parentElement.remove();
    </script>
@endpush
@section('body_content')

    <div class="bg-gray-800 flex justify-between items-center rounded-l pl-2 mb-3 p-2">
        <p class="text-white font-medium text-lg">Edit Products </p>
        <a href="{{ route('dpanel.product.index') }}" class="bg-violet-500 py-1 px-2 rounded">Back</a>
    </div>
{{--    Error Any--}}
    @if ($errors->any())
        <div class="bg-red text-red-500 px-2 py-1 rounded border border-red-500 mb-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
{{--    Error Any End--}}



    <div class="w-full ">
        <form action="{{ route('dpanel.product.update',$data->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Product Basic Details --}}
            <section>
                <h2 class="mb-2 text-lg">Product Basic Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-y-2 gap-x-4 bg-gray-800 p-2 ">
                    <div>
                        <label class="text-white">Product Category</label>
                        <select name="category_id" class="w-full border border-gray-700 rounded py-0.5 focus:outline-none">
                            <option value="">select</option>
                            @foreach ($categories as $item)
                                <option value="{{ $item->id }}" @selected($data->category_id==$item->id)>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-white">Product Brand</label>
                        <select name="brand_id" class="w-full  border border-gray-700 rounded py-0.5 focus:outline-none">
                            <option value="">select</option>
                            @foreach ($brands as $item)
                                <option value="{{ $item->id }}" @selected($data->brand_id==$item->id)>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-white">Product Name / Title</label>
                        <input type="text" name="title" value="{{$data->title}}" placeholder="Enter Product Title"
                               class="w-full px-2 border  rounded py-0.5 focus:outline-none">
                    </div>
                    <div class="md:col-span-3">
                        <label class="text-white">Product Description </label>
                        <textarea name="description" rows="3" placeholder="Enter description"
                                  class="w-full px-2 border  rounded py-0.5 focus:outline-none">
                            {{$data->description}}
                        </textarea>

                    </div>
                </div>
            </section>

            {{-- Product Variant Details --}}
            <section id="product_variants" class="bg-gray-800 px-3 rounded mb-3 mt-2">
                <h2 class="mb-2 text-lg text-white">Product Variants</h2>

                @foreach($data->variant as $VariantItem)
                    <input type="hidden" name="variant_ids[]" value="{{$VariantItem->id}}">
                    <div class="flex justify-between gap-3 mb-2 border-b border-gray-400 pb-2">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                            <div>
                                <label class="text-white"> Color</label>
                                <select name="color_id[]"
                                        class="w-full  border border-gray-700 rounded py-0.5 focus:outline-none" required>
                                    <option value="">select</option>
                                    @foreach ($color as $item)
                                        <option value="{{ $item->id }}" @selected($item->id== $VariantItem->color_id)>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="text-white"> Size</label>
                                <select name="size_id[]"
                                        class="w-full  border border-gray-700 rounded py-0.5 focus:outline-none" required>
                                    <option value="">select</option>
                                    @foreach ($size as $item)
                                        <option value="{{ $item->id }}" @selected($item->id== $VariantItem->size_id)>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-white">MRP / Unit</label>
                                <input type="number" name="mrp[]" value="{{$VariantItem->mrp}}" placeholder="Enter Product MRP"
                                       class="w-full px-2 border  rounded py-0.5 focus:outline-none" required>
                            </div>

                            <div>
                                <label class="text-white">Price / Unit</label>
                                <input type="number" name="selling_price[]" value="{{$VariantItem->selling_price}}" placeholder="Enter Product Price"
                                       class="w-full px-2 border  rounded py-0.5 focus:outline-none" required>
                            </div>
                            <div>
                                <label class="text-white">Stock </label>
                                <input type="number" name="stock[]" value="{{$VariantItem->stock}}" placeholder="Enter Available Stock"
                                       class="w-full px-2 border  rounded py-0.5 focus:outline-none" required>
                            </div>

                        </div>


                        <div class="flex items-end">
                            <button type="button" onclick="removeVariant(this)" class="bg-red-500 border text-center w-16 py-1 rounded text-white">Remove</button>
                        </div>
                    </div>

                @endforeach
                <div class="flex  justify-between gap-3 mb-2 border-b border-gray-400 pb-2">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    </div>
                        <div class="flex items-end">
                            <button type="button" onclick="addVariant(this,false)"
                                    class="bg-indigo-500 text-center w-16 py-1 rounded text-white">Add</button>
                        </div>
                </div>
            </section>

            {{-- Product Image --}}
            <section class="bg-gray-800 px-3 rounded mb-3 mt-2 p-3">

                <h2 class="mb-2 text-lg text-white">Product Images (800x1200px or 2:3)</h2>

                <div id="image_container" class="grid grid-cols-1 md:grid-cols-8 gap-3">

                    @foreach($data->image as $item)
                        <input type="hidden" name="image_ids[]" value="{{$item->id}}">
                        <div class="relative">
                            <label for="img-1" class="flex items-center justify-center rounded-md shadow cursor-pointer">
                                <input type="file" name="images[]" id="img-1" onchange="setImagePreview(this, event)"
                                       accept="image/*" class="hidden" >
                                <img src="{{asset('storage/'. $item->path)}}"
                                     class="rounded-md aspect-[2/3] object-cover" alt="">
                            </label>
                            <span onclick='deleteImage(this)' class="absolute top-1 right-1 cursor-pointer w-7 h-7 flex items-center justify-center bg-white hover:bg-red-500 bg-opacity hover:bg-opacity-100 hover:text-white duration-300 shodow rounded-full">
                    <i class='bx bxs-trash'></i>
                    </span>
                        </div>
                    @endforeach

                        <div class="relative">
                            <label for="img-1" class="flex items-center justify-center rounded-md shadow cursor-pointer">
                                <input type="file" name="images[]" id="img-1" onchange="setImagePreview(this, event)"
                                       accept="image/*" class="hidden" >
                                <img src="https://placehold.jp/400x600.png?text=Add%20Image"
                                     class="rounded-md aspect-[2/3] object-cover" alt="">
                            </label>

                        </div>


                </div>
            </section>

            <button  class="text-white bg-indigo-500 text-center font-medium w-full py-2">Update Product</button>
        </form>
    </div>
@endsection
