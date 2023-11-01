<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use  App\Http\Controllers\Admin\LoaiCuaHangController;
use  App\Http\Controllers\Admin\DanhMucTinController;
use  App\Http\Controllers\Admin\TinTucController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/', [AdminController::class, 'index_admin'])->name('index');

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/block/{id}',[UserController::class, 'block'])->name('block');
    Route::get('/unblock/{id}',[UserController::class, 'unblock'])->name('unblock');
});

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
});

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
});

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
});

Route::get('post', [AdminController::class, 'list_post'])->name('post');
Route::get('store', [AdminController::class, 'list_reg'])->name('store');
Route::get('list-profit-day', [AdminController::class, 'list_profit_day'])->name('profit-day');
Route::get('list-profit-month', [AdminController::class, 'list_profit_month'])->name('profit-month');

Route::get('pass',function(){
    return bcrypt('hihi');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
