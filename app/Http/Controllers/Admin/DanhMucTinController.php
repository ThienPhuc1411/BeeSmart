<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DanhMucTin;

class DanhMucTinController extends Controller
{
    //
    public function index(){
        $data = DanhMucTin::all();
        $title = "Danh mục tin";
        return view("admin.loai-tin.list-post-type",compact('data','title'));
    }

    public function add(Request $request){

    }
}
