<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\nhaCungCapController;
use App\Http\Controllers\ThuongHieuController;
use App\Http\Controllers\LoaiSanPhamController;
use App\Http\Controllers\DanhMucSanPhamController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('nha-cung-cap', nhaCungCapController::class);
Route::resources([
    'thuong-hieu' => ThuongHieuController::class,
    'loai-san-pham' => LoaiSanPhamController::class,
    'danh-muc-san-pham' => DanhMucSanPhamController::class
]);
