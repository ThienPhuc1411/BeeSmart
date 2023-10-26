<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\nhaCungCapController;
use App\Http\Controllers\ThuongHieuController;
use App\Http\Controllers\LoaiSanPhamController;
use App\Http\Controllers\DanhMucSanPhamController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


use App\Http\Controllers\SanPhamController;


Route::post('san-pham',[SanPhamController::class,'store']);
Route::get('san-pham',[SanPhamController::class,'index']);
Route::get('san-pham/{id}',[SanPhamController::class,'show']);
Route::post('san-pham/{id}',[SanPhamController::class,'update']);
Route::delete('san-pham/{id}',[SanPhamController::class,'destroy']);
Route::get('test',[SanPhamController::class,'sort_search']);


Route::resource('nha-cung-cap', nhaCungCapController::class);
Route::resources([
    'thuong-hieu' => ThuongHieuController::class,
    'loai-san-pham' => LoaiSanPhamController::class,
    'danh-muc-san-pham' => DanhMucSanPhamController::class
]);

