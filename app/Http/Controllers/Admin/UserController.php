<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class UserController extends Controller
{
    //
    public function index(){
        $title = 'Khách hàng';
        $users = DB::table('users')->paginate(10)->withQueryString();
        return view('admin.list-client',compact('users','title'));
    }

    public function block(Request $request){
        $title = 'Khách hàng';
        $id = $request->id;
        $user = User::find($id);
        $user->status = 0;
        $user->save();
        $users = DB::table('users')->paginate(10)->withQueryString();
        return view('admin.list-client',compact('users','title'));
        // dd($id);
    }

    public function unblock(Request $request){
        $title = 'Khách hàng';
        $id = $request->id;
        $user = User::find($id);
        $user->status = 1;
        $user->save();
        $users = DB::table('users')->paginate(10)->withQueryString();
        return view('admin.list-client',compact('users','title'));
        // dd($id);
    }

    public function updateAdvance(Request $request){
        $title = 'Khách hàng';
        $id = $request->id;
        $user = User::find($id);
        $user->loai = 2;
        $user->save();
        $users = DB::table('users')->paginate(10)->withQueryString();
        return view('admin.list-client',compact('users','title'));
        // dd($id);
    }

    public function updatePremium(Request $request){
        $title = 'Khách hàng';
        $id = $request->id;
        $user = User::find($id);
        $user->loai = 3;
        $user->save();
        $users = DB::table('users')->paginate(10)->withQueryString();
        return view('admin.list-client',compact('users','title'));
        // dd($id);
    }
}
