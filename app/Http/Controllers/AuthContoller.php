<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthContoller extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
           'email'=> 'required|email',
           'password'=> 'required'
        ]);

        if ($validator->fails())return response()->json($validator->messages(),401);

        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $request->session()->regenerate();
            return  response()->json(['msg'=>'Login Successfully'],200);
        };
        return  response()->json(['msg'=>'The provided Credentials not match out records'],401);

    }
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'first_name'=> 'required',
            'last_name'=> 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|'
        ]);

        if ($validator->fails())return response()->json($validator->messages(),401);

        $user = new  User;
        $user->name = $request->first_name ." ".$request->last_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        if (Auth::loginUsingId($user->id)){
            $request->session()->regenerate();
            return  response()->json(['msg'=>'Register Successfully'],200);
        };
        return  response()->json(['msg'=>'Failed Please try again.'],401);

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
