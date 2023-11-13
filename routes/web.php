<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use  App\Http\Controllers\Admin\LoaiCuaHangController;
use  App\Http\Controllers\Admin\DanhMucTinController;
use  App\Http\Controllers\Admin\TinTucController;
use App\Http\Controllers\Admin\BinhLuanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VnPayController;
use App\Http\Controllers\Admin\LoaiSanPhamController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




    Route::get('/login',[AuthController::class,'login'])->name('login');
    Route::post('/login',[AuthController::class,'loginPost'])->name('login');


Route::get('', [AdminController::class, 'index_admin'])->name('index')->middleware(['admin','auth']);

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/block/{id}',[UserController::class, 'block'])->name('block');
    Route::get('/unblock/{id}',[UserController::class, 'unblock'])->name('unblock');
})->middleware(['admin','auth']);

Route::prefix('loai-cua-hang')->name('store-type.')->group(function () {
    Route::get('/',[LoaiCuaHangController::class,'index'])->name('index');
    Route::get('/edit/{id}',[LoaiCuaHangController::class,'edit'])->name('edit');
    Route::post('/edit/{id}',[LoaiCuaHangController::class,'update'])->name('edit');
    Route::get('add',[LoaiCuaHangController::class,'store'])->name('add');
    Route::post('add',[LoaiCuaHangController::class,'handleStore'])->name('add');
    Route::get('/delete/{id}',[LoaiCuaHangController::class,'delete'])->name('delete');
    Route::get('/restore/{id}',[LoaiCuaHangController::class,'restore'])->name('restore');
    Route::get('/trash',[LoaiCuaHangController::class,'trash'])->name('trash');
    Route::get('/force-delete/{id}',[LoaiCuaHangController::class,'forceDelete'])->name('force-delete');
})->middleware(['admin','auth']);

Route::prefix('loai-tin')->name('post-type.')->group(function () {
    Route::get('/',[DanhMucTinController::class,'index'])->name('index');
    Route::get('/edit/{id}',[DanhMucTinController::class,'edit'])->name('edit');
    Route::post('/edit/{id}',[DanhMucTinController::class,'update'])->name('edit');
    Route::get('add',[DanhMucTinController::class,'store'])->name('add');
    Route::post('add',[DanhMucTinController::class,'handleStore'])->name('add');
    Route::get('/delete/{id}',[DanhMucTinController::class,'delete'])->name('delete');
    Route::get('/restore/{id}',[DanhMucTinController::class,'restore'])->name('restore');
    Route::get('/trash',[DanhMucTinController::class,'trash'])->name('trash');
    Route::get('/force-delete/{id}',[DanhMucTinController::class,'forceDelete'])->name('force-delete');
    Route::get('/show/{id}',[DanhMucTinController::class,'show'])->name('show');
    Route::get('/hide/{id}',[DanhMucTinController::class,'hide'])->name('hide');
})->middleware(['admin','auth']);

Route::prefix('loai-san-pham')->name('product-type.')->group(function () {
    Route::get('/',[LoaiSanPhamController::class,'index'])->name('index');
    Route::get('/edit/{id}',[LoaiSanPhamController::class,'edit'])->name('edit');
    Route::post('/edit/{id}',[LoaiSanPhamController::class,'update'])->name('edit');
    Route::get('add',[LoaiSanPhamController::class,'store'])->name('add');
    Route::post('add',[LoaiSanPhamController::class,'handleStore'])->name('add');
    Route::get('/delete/{id}',[LoaiSanPhamController::class,'delete'])->name('delete');
    Route::get('/restore/{id}',[LoaiSanPhamController::class,'restore'])->name('restore');
    Route::get('/trash',[LoaiSanPhamController::class,'trash'])->name('trash');
    Route::get('/force-delete/{id}',[LoaiSanPhamController::class,'forceDelete'])->name('force-delete');
})->middleware(['admin','auth']);

Route::prefix('tin-tuc')->name('post.')->group(function () {
    Route::get('/',[TinTucController::class,'index'])->name('index');
    Route::get('/show/{id}',[TinTucController::class,'show'])->name('show');
    Route::get('/hide/{id}',[TinTucController::class,'hide'])->name('hide');
    Route::get('/edit/{id}',[TinTucController::class,'update'])->name('edit');
    Route::post('/edit/{id}',[TinTucController::class,'handleUpdate'])->name('edit');
    Route::get('add',[TinTucController::class,'add'])->name('add');
    Route::post('add',[TinTucController::class,'handleAdd'])->name('add');
    Route::get('/delete/{id}',[TinTucController::class,'delete'])->name('delete');
    Route::get('/restore/{id}',[TinTucController::class,'restore'])->name('restore');
    Route::get('/trash',[TinTucController::class,'trash'])->name('trash');
    Route::get('/force-delete/{id}',[TinTucController::class,'forceDelete'])->name('force-delete');
})->middleware(['admin','auth']);

Route::prefix('binh-luan')->name('cmt.')->group(function () {
    Route::get('/',[BinhLuanController::class,'index'])->name('index');
    Route::get('/approve/{id}',[BinhLuanController::class,'approve'])->name('approve');
    Route::get('/trash',[BinhLuanController::class,'trash'])->name('trash');
    Route::get('/delete/{id}',[BinhLuanController::class,'delete'])->name('delete');
    Route::get('/force-delete/{id}',[BinhLuanController::class,'force-delete'])->name('force-delete');
    Route::get('restore/{id}',[BinhLuanController::class,'restore'])->name('restore');
})->middleware(['admin','auth']);

Route::delete('logout',[AuthController::class,'logout'])->name('logout')->middleware(['admin','auth']);

Route::get('store', [AdminController::class, 'list_reg'])->name('store')->middleware(['admin','auth']);
Route::get('list-profit-day', [AdminController::class, 'list_profit_day'])->name('profit-day')->middleware(['admin','auth']);
Route::get('list-profit-month', [AdminController::class, 'list_profit_month'])->name('profit-month')->middleware(['admin','auth']);

Route::get('pass',function(){
    return bcrypt('hihi');
});

Route::post('/vnpay_payment',[VnPayController::class,'vnpay_payment'])->name('vnpay');
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// // Auth::routes();

// // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// // Auth::routes();

// // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// // Auth::routes();

// // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




