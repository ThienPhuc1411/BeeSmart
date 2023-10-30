<?php

use App\Http\Controllers\HoaDonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CuaHangController;
use App\Http\Controllers\LoaiCHController;
use App\Http\Controllers\DanhMucTinController;
use App\Http\Controllers\TinController;
use App\Http\Controllers\nhaCungCapController;
use App\Http\Controllers\ThuongHieuController;
use App\Http\Controllers\LoaiSanPhamController;
use App\Http\Controllers\DanhMucSanPhamController;
use App\Http\Controllers\SanPhamController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('cua-hang', CuaHangController::class);
Route::resource('loai-cua-hang',LoaiCHController::class);
Route::resource('danh-muc-tin',DanhMucTinController::class);
Route::resource('tin',TinController::class);
Route::get('searchByTitle',[TinController::class,'searchByTitle']);


// Route::resource('san-pham', san_phamController::class);
Route::post('san-pham',[SanPhamController::class,'store']);
Route::get('san-pham',[SanPhamController::class,'index']);
Route::get('san-pham/{id}',[SanPhamController::class,'show']);
Route::put('san-pham/{id}',[SanPhamController::class,'update']);
Route::patch('san-pham/{id}',[SanPhamController::class,'update']);
Route::delete('san-pham/{id}',[SanPhamController::class,'destroy']);

Route::get('sp-dm/{id}',[SanPhamController::class,'sptheoDm']);
Route::get('sp-th',[SanPhamController::class,'sptheoTh']);
Route::get('sp-ch',[SanPhamController::class,'sptheoCh']);
Route::get('sp-loaiSp',[SanPhamController::class,'sptheoLoaiSp']);
Route::get('sp-ncc',[SanPhamController::class,'sptheoNcc']);

Route::resource('nha-cung-cap', nhaCungCapController::class);
Route::resources([
    'thuong-hieu' => ThuongHieuController::class,
    'loai-san-pham' => LoaiSanPhamController::class,
    'danh-muc-san-pham' => DanhMucSanPhamController::class,
    'hoa-don' => HoaDonController::class
]);
