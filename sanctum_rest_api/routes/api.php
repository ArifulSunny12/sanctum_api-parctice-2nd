<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;


//Route::get('/user', function (Request $request) {
  //  return $request->user();
//})->middleware('auth:sanctum');

route::controller(AuthController::class)->group(function(){

    Route::post('register','register');
    Route::post('login','login');
    Route::get('profile','userProfile')->middleware('auth:sanctum');
    Route::get('logout','logOut')->middleware('auth:sanctum');
    
    
});
