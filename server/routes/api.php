<?php
use App\Http\Controllers\APICategoryController;
use App\Http\Controllers\APICustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\APIOrderController;
Use App\Http\Controllers\APIBookController;
Use App\Http\Controllers\APIAuthController;

//customner
Route::get('/customer',[APICustomerController::class,'index']);
//book
Route::get('/category', [APICategoryController::class, 'getAllCategory']);
Route::get('/book-category', [APICategoryController::class, 'getListCategoryAndListBook']);
Route::get('/books',[APIBookController::class, 'index'] );
Route::get('/books/{categoryId}', [APIBookController::class,'getBooksByCategory']);
Route::get('/book',[APIBookController::class,'getListBook']);
Route::get('/banner',[APIBookController::class,'getBanner']);
Route::get('/combos',[APIBookController::class,'getCombo']);
Route::get('/search', [APIBookController::class, 'search']);
Route::get('/book/{id}',[APIBookController::class,'getBook']);
Route::get('/related-books/{id}',[APIBookController::class,'getRelatedBooks']);
Route::get('/filter-books/{category}', [APIBookController::class, 'filterByCategory']);
Route::get('/filter-books-by-price/{minPrice}/{maxPrice}', [APIBookController::class, 'filterByPrice']);


Route::post('/login', [APIAuthController::class,'login'])->middleware('cors');


Route::middleware(['cors', 'auth:api'])->group(function(){
    Route::get('/me', [APIAuthController::class, 'me']);
    Route::post('logout', [APIAuthController::class, 'logout']);
    Route::post('/update-info/{id}', [APICustomerController::class, 'update']);
    //order
    Route::post('/order', [APIOrderController::class,'store']);
    Route::get('/order',[APIOrderController::class,'index']);
    Route::get('/order/{id}',[APIOrderController::class,'show']);
    Route::post('/order/create',[APIOrderController::class,'store']);
    Route::get('/order/detail/{id}',[APIOrderController::class,'details']);
    Route::get('/order/find/{id}',[APIOrderController::class,'show']);
    //customer
    Route::post('/customer/store',[APICustomerController::class,'store']);
});