<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\san_phamController;


// Route::resource('san-pham', san_phamController::class);
Route::post('san-pham',[san_phamController::class,'store']);
Route::get('san-pham',[san_phamController::class,'index']);
Route::get('san-pham/{id}',[san_phamController::class,'show']);
Route::put('san-pham/{id}',[san_phamController::class,'update']);
Route::delete('san-pham/{id}',[san_phamController::class,'destroy']);
