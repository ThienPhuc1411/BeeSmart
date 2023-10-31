<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::all();
        $msg = 'haha';
        return view('admin.list-client',compact('users'))->with('msg',$msg);
    }
}
