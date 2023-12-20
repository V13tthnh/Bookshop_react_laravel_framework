<?php

use App\Http\Controllers\APICategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\APIOrderController;
Use App\Http\Controllers\APIUserController;
Use App\Http\Controllers\APIBookController;
Use App\Http\Controllers\APIAuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/category', [APICategoryController::class, 'getAllCategory']);
Route::get('/book-category', [APICategoryController::class, 'getListCategoryAndListBook']);

Route::get('/order',[APIOrderController::class,'index']);
Route::post('/order/create',[APIOrderController::class,'store']);
Route::post('/order/details/{id}',[APIOrderController::class,'details']);
Route::post('/order/find',[APIOrderController::class,'show']);

Route::get('/user',[APIUserController::class,'index']);
Route::post('/user/create',[APIUserController::class,'store']);

Route::get('/book',[APIBookController::class,'getListBook']);
Route::get('/search', [APIBookController::class, 'search']);
Route::get('/book/{id}',[APIBookController::class,'getBook']);
Route::get('/filter-books/{category}', [APIBookController::class, 'filterByCategory']);
Route::get('/filter-books-by-price/{minPrice}/{maxPrice}', [APIBookController::class, 'filterByPrice']);



Route::post('/login', [APIAuthController::class,'login']);
// Route::post('logout', AuthController::class,'logout');
// Route::post('refresh', AuthController::class,'refresh');
Route::middleware('auth:api')->group(function(){
    Route::get('/me', [APIAuthController::class, 'me']);
});