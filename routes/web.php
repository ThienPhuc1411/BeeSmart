<?php

use Illuminate\Support\Facades\Route;

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


Use App\Http\Controllers\AdminController;
Route::prefix('admin')->group(function(){
    Route::get('/',[AdminController::class,'index_admin']);
    Route::get('tb-user',[AdminController::class,'tb_user']);
    Route::get('tb-post',[AdminController::class,'tb_post']);
});

