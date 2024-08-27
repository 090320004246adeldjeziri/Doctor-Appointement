<?php

use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
// Route::get('/users', [UserController::class, 'index']);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
//TODO this correct one 
// Route::middleware('auth:sanctum')->get('/user', function (Request $request){
//     return $request->user();
// });
Route::middleware('auth:sanctum')->group(
    function(){
        Route::get('/user',[UserController::class,'index']);
        Route::post('/book',[AppointmentsController::class,'store']);
        Route::get('/appointments',[AppointmentsController::class,'index']);


    }
);