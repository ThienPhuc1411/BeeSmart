y<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

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

Route::group(['middleware' => 'guest'],function(){
    Route::get('/login',[AuthController::class,'login'])->name('login');
    Route::post('/login',[AuthController::class,'loginPost'])->name('login');
});

Route::group(['middleware' => 'auth'],function(){
    Route::get('/', [AdminController::class, 'index_admin']);
    Route::get('list-client', [AdminController::class, 'list_client']);
    Route::get('list-post', [AdminController::class, 'list_post']);
    Route::get('list-ncc', [AdminController::class, 'list_ncc']);
    Route::get('list-reg', [AdminController::class, 'list_reg']);
    Route::get('list-profit-day', [AdminController::class, 'list_profit_day']);
    Route::get('list-profit-month', [AdminController::class, 'list_profit_month']);
    Route::delete('/logout',[AuthController::class,'logout'])->name('logout');
});


Route::get('pass',function(){
    return bcrypt('hihi');
});


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// // Auth::routes();

// // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// // Auth::routes();

// // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// // Auth::routes();

// // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




