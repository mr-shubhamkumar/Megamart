<?php

namespace App\Http\Controllers\Dpanel;
use App\Models\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
public function index()
    {
        $data =  Brand::all();
        return view('dpanel.brand',compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:brands'
        ]);

        $data= new Brand(); 
        $data->name = $request->name;
        $data->slug = Str::slug($request->name);
        $data->is_active = true;
        $data->save();
        
        return redirect()->back()->with('success','New Brand added successfully.');
    }

   

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|unique:brands,name,'.$id
        ]);

        $data=  Brand::find($id); 
        $data->name = $request->name;
        $data->slug = Str::slug($request->name);
        $data->is_active = $request->is_active;
        $data->save();
        return redirect()->back()->with('success','Brand Updated successfully.');
    }

}


