<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AdminsController;
use  App\Http\Controllers\CategoriesController;
// use  App\Http\Controllers\SuppliersController;

Route::get('/admin/login',[AdminsController::class,'login'])->name('admin.login')->middleware('guest');
Route::post('/admin/login-handler', [AdminsController::class, 'loginHandler'])->name('admin.loginHandler');
// admin - viet thanh
Route::middleware('auth')->group(function(){
    Route::prefix('admin')->group(function(){
        //Viet thanh
        Route::name('admin.')->group(function(){
            Route::get('logout', [AdminsController::class, 'logout'])->name('logout');
            Route::get('/',[AdminsController::class,'index'])->name('index'); 
            Route::get('show/{id}',[AdminsController::class,'show'])->name('show'); 
            Route::get('create', [AdminsController::class, 'create'])->name('create');
            Route::post('store', [AdminsController::class, 'store'])->name('store');
            Route::get('edit/{id}', [AdminsController::class, 'edit'])->name('edit');   
            Route::post('update', [AdminsController::class, 'update'])->name('update');
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
            Route::get('show/{id}',[AdminsController::class,'show'])->name('show'); 
            Route::get('edit/{id}',[CategoriesController::class,'edit'])->name('edit');
            Route::post('update',[CategoriesController::class,'update'])->name('update');
            Route::post('destroy/{id}', [CategoriesController::class, 'destroy'])->name('destroy');
            Route::get('trash', [CategoriesController::class, 'trash'])->name('trash');
            Route::get('untrash/{id}', [CategoriesController::class, 'untrash'])->name('untrash');
        });
    });

    // Route::prefix('supplier')->group(function(){
    //     Route::name('supplier.')->group(function(){
    //         Route::get('/',[SuppliersController::class,'index'])->name('index');
    //         Route::get('create',[SuppliersController::class,'create'])->name('create');
    //         Route::get('show/{id}',[AdminsController::class,'show'])->name('show'); 
    //         Route::post('store',[SuppliersController::class,'store'])->name('store');
    //         Route::get('edit/{id}',[SuppliersController::class,'edit'])->name('edit');
    //         Route::post('update',[SuppliersController::class,'update'])->name('update');
    //         Route::post('destroy/{id}', [SuppliersController::class, 'destroy'])->name('destroy');
    //         Route::get('delete/{id}', [SuppliersController::class, 'delete'])->name('delete');
    //         Route::get('trash', [SuppliersController::class, 'trash'])->name('trash');
    //         Route::get('untrash/{id}', [SuppliersController::class, 'untrash'])->name('untrash');
    //     });
    // });
});




