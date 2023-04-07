<?php

namespace App\Http\Controllers\Dpanel;
use App\Models\Color;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ColorController extends Controller
{
    public function index()
    {
        $data =  Color::all();
        return view('dpanel.color',compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:colors',
            'code'=>'required|unique:colors',
        ]);

        $data= new Color(); 
        $data->name = $request->name;
        $data->code = $request->code;
        $data->is_active = true;
        $data->save();
        
        return redirect()->back()->with('success','New Color added successfully.');
    }

   

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|unique:colors,name,'.$id,
            'code'=>'required|unique:colors,code,'.$id
        ]);

        $data=  Color::find($id); 
        $data->name = $request->name;
        $data->code = $request->code;
        $data->is_active = $request->is_active;
        $data->save();
        return redirect()->back()->with('success','Color Updated successfully.');
    }
}
