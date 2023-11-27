<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\APIOrderController;

Use App\Http\Controllers\APIUserController;

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

Route::get('/order',[APIOrderController::class,'index']);
Route::post('/order/create',[APIOrderController::class,'store']);
Route::post('/order/details/{id}',[APIOrderController::class,'details']);
Route::post('/order/find',[APIOrderController::class,'show']);

Route::get('/user',[APIUserController::class,'index']);
Route::post('/user/create',[APIUserController::class,'store']);