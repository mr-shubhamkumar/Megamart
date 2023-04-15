<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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


    public function forgot(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'=> 'required|email',
        ]);

        if ($validator->fails())return response()->json('The email filed is required',401);

        $user = User::where('email', $request->email)->first();
        if ($user){
            $token = Str::random(64);
            $user->remember_token = $token ;
            $user->save();

            $link = route('reset',['token'=>$token]);
            Mail::to($request->email)->send(new ForgotPassword($link));

            return  response()->json(['msg'=>'Reset Email Send Successfully'],200);
        }

        return  response()->json(['msg'=>'The provided email not match out records'],401);

    }

    public function reset(Request $request)
    {
    }
}
