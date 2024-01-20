<?php
use App\Http\Controllers\APICategoryController;
use App\Http\Controllers\APIComboController;
use App\Http\Controllers\APICommentController;
use App\Http\Controllers\APICustomerController;
use App\Http\Controllers\APILoginFacebookController;
use App\Http\Controllers\APILoginGoogleController;
use App\Http\Controllers\APIOnlineCheckOutController;
use App\Http\Controllers\APIReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\APIOrderController;
Use App\Http\Controllers\APIBookController;
Use App\Http\Controllers\APIAuthController;

//api đăng ký người dùng
Route::post('/customer/register',[APICustomerController::class,'register']);
Route::get('/customer/account/verify/{token}', [APICustomerController:: class, 'register']);
//reset-password
Route::post('/customer/forgot-password',[APICustomerController::class,'forgetPassword']);
Route::get('/customer/reset-password/{token}',[APICustomerController::class,'resetpasswordLoad']);
Route::post('/customer/reset-password',[APICustomerController::class,'resetPassword']);
//book
Route::get('/category', [APICategoryController::class, 'getAllCategory']);
Route::get('/book-category', [APICategoryController::class, 'getListCategoryAndListBook']);
Route::get('/books',[APIBookController::class, 'index'] );
Route::get('/hot-selling-books',[APIBookController::class, 'hotSellingBook'] );
Route::get('/new-books',[APIBookController::class, 'newBooks'] );
Route::get('/sales-books',[APIBookController::class, 'salesBooks'] );
Route::get('/product/category/{id}', [APICategoryController::class,'getListBookInCategory']);
Route::get('/book',[APIBookController::class,'getListBook']);
Route::get('/banner',[APIBookController::class,'getBanner']);
Route::get('/combos',[APIBookController::class,'getCombo']);
Route::get('/book/search', [APIBookController::class, 'search']);
Route::get('/book/{id}',[APIBookController::class,'getBook']);
Route::get('/related-books/{id}',[APIBookController::class,'getRelatedBooks']);
Route::get('/filter-books/{category}', [APIBookController::class, 'filterByCategory']);
Route::get('/filter-books-by-price/{minPrice}/{maxPrice}', [APIBookController::class, 'filterByPrice']);
Route::get('/filter-books-by-type/{type}', [APIBookController::class, 'filterByType']);
Route::get('/show-pdf/{id}', [APIBookController::class, 'showPDF'])->middleware('cors');
Route::get('/featured-book', [APIBookController::class, 'featuredBook']);
//reviews
Route::get('/book/reviews/{id}',[APIReviewController::class,'getBookReviews']);
Route::get('/combo/reviews/{id}',[APIReviewController::class,'getComboReviews']);
//comments
Route::get('/book/comments/{id}', [APICommentController::class, 'getBookComments']);
Route::get('/combo/comments/{id}', [APICommentController::class, 'getComboComments']);
//combo
Route::get('/combo', [APIComboController:: class, 'getAllCombo']);
Route::get('/combo/detail/{id}', [APIComboController:: class, 'getComboDetail']);
//auth
Route::post('/login', [APIAuthController::class,'login'])->middleware('cors');
Route::post('/checkout-online', [APIOnlineCheckOutController::class, 'onlineCheckout']);

Route::get('/auth/facebook', [APILoginFacebookController:: class, 'redirectToFacebook']);
Route::get('/auth/facebook/callback', [APILoginFacebookController:: class, 'handleFacebookCallback']);

Route::get('/auth/google', [APIAuthController:: class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [APIAuthController:: class, 'handleGoogleCallback']);

route::get('/vnp/callback', [APIOnlineCheckOutController::class, 'vnPayCallBack']);

Route::middleware(['cors', 'auth:api'])->group(function(){
    Route::get('/me', [APIAuthController::class, 'me']);
    Route::post('/logout', [APIAuthController::class, 'logout']);
    Route::post('/update-info/{id}', [APICustomerController::class, 'update']);
    //order
    Route::post('/order', [APIOrderController::class,'store']);
    Route::get('/order',[APIOrderController::class,'index']);
    Route::get('/order/{id}',[APIOrderController::class,'show']);
    Route::post('/order/create',[APIOrderController::class,'store']);
    Route::get('/order/detail/{id}',[APIOrderController::class,'details']);
    Route::get('/order/find/{id}',[APIOrderController::class,'show']);
    Route::get('/order/cancel/{id}', [APIOrderController::class, 'cancel']);
    Route::get('/order/repurchase/{id}', [APIOrderController::class, 'repurchase']);
    Route::post('/review-handler', [APIReviewController::class, 'reviewHandler']);
    //comment
    Route::post('/comment-handler', [APICommentController::class, 'comment']);
    Route::post('/reply-handler/{id}', [APICommentController::class, 'reply']);
    //customer
    Route::post('/customer/store',[APICustomerController::class,'store']);
});