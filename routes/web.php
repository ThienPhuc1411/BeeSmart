<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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


Route::get('/', [AdminController::class, 'index_admin']);

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/block/{id}',[UserController::class, 'index'])->name('block');
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
