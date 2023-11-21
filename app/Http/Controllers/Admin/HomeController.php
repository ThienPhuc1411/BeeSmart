<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoaiCuaHang;
use App\Models\CuaHang;


class HomeController extends Controller
{
    //
    public function index()
    {
        $title = "Trang chủ";
        $count = LoaiCuaHang::withCount('cuaHang')->get();
        $data = [];
        $chartData = "";
        foreach ($count as $v) {
            $data[] = [
                'labels' => $v->ten,
                'countCh' => $v->cua_hang_count
            ];
        }
        for($i = 0; $i < count($data); $i++){
            $chartData .= "['" . $data[$i]['labels'] . "','" . $data[$i]['countCh'] . "'],";
        }
        $chartData = rtrim($chartData,",");
        // echo $chartData;
        return view("admin.index", compact('title', 'data','chartData'));
    }
}
