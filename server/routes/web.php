<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AdminsController;
use  App\Http\Controllers\CategoriesController;
Route::get('/admin/login',[AdminsController::class,'login'])->name('admin.login')->middleware('guest');
Route::post('/admin/login-handler', [AdminsController::class, 'loginHandler'])->name('admin.loginHandler');
// admin - viet thanh
Route::middleware('auth')->group(function(){
    Route::prefix('admin')->group(function(){
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
});


Route::get('/category',[CategoriesController::class,'index'])->name('category.index');
Route::get('/category/create',[CategoriesController::class,'create'])->name('category.create');
Route::post('/category/store',[CategoriesController::class,'store'])->name('category.store');
Route::get('/category/edit/{id}',[CategoriesController::class,'edit'])->name('category.edit');
Route::post('/category/edit/{id}',[CategoriesController::class,'update'])->name('category.update');
Route::post('/category/destroy/{id}', [CategoriesController::class, 'destroy'])->name('category.destroy');
Route::get('/category/trash', [CategoriesController::class, 'trash'])->name('category.trash');
Route::get('/category/untrash/{id}', [CategoriesController::class, 'untrash'])->name('category.untrash');

