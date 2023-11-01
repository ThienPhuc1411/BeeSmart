<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(){
        return view('/auth/login');
    }
    public function loginPost(Request $request){
        $credetails=[
            'email'=>$request->email,
            'password'=>$request->password
        ];

        if(Auth::attempt($credetails)){
            return redirect('')->with('success','Đăng nhập thành công');
        }

        return back()->with('error','Email hoặc Password sai');


    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
