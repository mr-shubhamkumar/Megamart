<?php
namespace App\Http\Controllers\Dpanel;
use App\Models\Size;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SizeController extends Controller
{
    public function index()
    {
        $data =  Size::all();
        return view('dpanel.size',compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:sizes',
            'code'=>'required|unique:sizes'
        ]);

        $data= new Size(); 
        $data->name = $request->name;
        $data->code = $request->code;
        $data->is_active = 1;
        $data->save();
        
        return redirect()->back()->with('success','New Size added successfully.');
    }

   

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|unique:sizes,name,'.$id,
            'code'=>'required|unique:sizes,code,'.$id
        ]);

        $data=  Size::find($id); 
        $data->name = $request->name;
        $data->code = $request->code;
        $data->is_active = $request->is_active;
        $data->save();
        return redirect()->back()->with('success','Size Updated successfully.');
    }
}
