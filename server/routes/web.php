<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AdminsController;
use  App\Http\Controllers\CategoriesController;
use  App\Http\Controllers\AuthorController;
Route::get('/admin/login',[AdminsController::class,'login'])->name('admin.login')->middleware('guest');
Route::post('/admin/login-handler', [AdminsController::class, 'loginHandler'])->name('admin.loginHandler');
// admin - viet thanh
Route::middleware('auth')->group(function(){
    Route::prefix('admin')->group(function(){
        //Viet thanh
        Route::name('admin.')->group(function(){
            Route::get('logout', [AdminsController::class, 'logout'])->name('logout');
            Route::get('/',[AdminsController::class,'index'])->name('index'); 
            Route::get('create', [AdminsController::class, 'create'])->name('create');
            Route::post('store', [AdminsController::class, 'store'])->name('store');
            Route::get('edit/{id}', [AdminsController::class, 'edit'])->name('edit');   
            Route::post('update/{id}', [AdminsController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [AdminsController::class, 'destroy'])->name('destroy');
            Route::get('trash', [AdminsController::class, 'trash'])->name('trash');
            Route::get('untrash/{id}', [AdminsController::class, 'untrash'])->name('untrash');
        });
    });
    //Thanh tuan
    Route::prefix('category')->group(function(){
        Route::name('category.')->group(function(){
            Route::get('/',[CategoriesController::class,'index'])->name('index');
            Route::get('create',[CategoriesController::class,'create'])->name('create');
            Route::post('store',[CategoriesController::class,'store'])->name('store');
            Route::get('edit/{id}',[CategoriesController::class,'edit'])->name('edit');
            Route::post('edit/{id}',[CategoriesController::class,'update'])->name('.update');
            Route::post('destroy/{id}', [CategoriesController::class, 'destroy'])->name('destroy');
            Route::get('trash', [CategoriesController::class, 'trash'])->name('trash');
            Route::get('untrash/{id}', [CategoriesController::class, 'untrash'])->name('untrash');
        });
    });
    //Thanh Nghia
    Route::prefix('author')->group(function(){
        Route::name('author.')->group(function(){
            Route::get('/',[AuthorController::class,'index'])->name('index');
            Route::get('create',[AuthorController::class,'create'])->name('create');
            Route::post('store',[AuthorController::class,'store'])->name('store');
            Route::get('edit/{id}',[AuthorController::class,'edit'])->name('edit');
            Route::post('update/{id}',[AuthorController::class,'update'])->name('update');
            Route::post('destroy/{id}',[AuthorController::class,'destroy'])->name('destroy');
            Route::get('trash', [AuthorController::class, 'trash'])->name('trash');
            Route::get('untrash/{id}', [AuthorController::class, 'untrash'])->name('untrash');
        });
    });
});




