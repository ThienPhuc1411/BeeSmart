<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LienHe;

class LienHeController extends Controller
{
    //
    public function index(){
        $title = "Thông báo";
        $lienhe = LienHe::orderBy('updated_at','desc')->get();
        return view('admin.list-lien-he',compact('title','lienhe'));
    }

    public function confirm(Request $request){
        $lienhe1 = LienHe::find($request->id);
        $lienhe1->status = 1;
        $lienhe1->save();
        $title = "Thông báo";
        $lienhe = LienHe::all();
        $msg = "Đã cập nhật thông báo";
        return redirect()->back()->with('msg',$msg);
    }
}
