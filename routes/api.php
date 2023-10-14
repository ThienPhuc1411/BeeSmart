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


use App\Http\Controllers\san_phamController;


// Route::resource('san-pham', san_phamController::class);
Route::post('san-pham',[san_phamController::class,'store']);
Route::get('san-pham',[san_phamController::class,'index']);
Route::get('san-pham/{id}',[san_phamController::class,'show']);
Route::put('san-pham/{id}',[san_phamController::class,'update']);
Route::patch('san-pham/{id}',[san_phamController::class,'update']);
Route::delete('san-pham/{id}',[san_phamController::class,'destroy']);

Route::get('sp-dm/{id}',[san_phamController::class,'sptheoDm']);
Route::get('sp-th/{id}',[san_phamController::class,'sptheoTh']);
Route::get('sp-ch/{id}',[san_phamController::class,'sptheoCh']);
Route::get('sp-loaiSp/{id}',[san_phamController::class,'sptheoLoaiSp']);
Route::get('sp-ncc/{id}',[san_phamController::class,'sptheoNcc']);

Route::resource('nha-cung-cap', nhaCungCapController::class);
Route::resources([
    'thuong-hieu' => ThuongHieuController::class,
    'loai-san-pham' => LoaiSanPhamController::class,
    'danh-muc-san-pham' => DanhMucSanPhamController::class
]);

