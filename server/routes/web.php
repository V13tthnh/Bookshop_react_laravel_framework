<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AdminsController;
use  App\Http\Controllers\AuthorController;
// admin - viet thanh
Route::get('/admin/login',[AdminsController::class,'login'])->name('admin.login')->middleware('guest');
Route::post('/admin/login-handler', [AdminsController::class, 'loginHandler'])->name('admin.loginHandler');
Route::get('/admin/logout', [AdminsController::class, 'logout'])->name('admin.logout');
Route::get('/admin',[AdminsController::class,'index'])->name('admin.index')->middleware('auth'); 
Route::get('/admin/create', [AdminsController::class, 'create'])->name('admin.create')->middleware('auth');
Route::post('/admin/store', [AdminsController::class, 'store'])->name('admin.store')->middleware('auth');   

//author - thanh nghia
Route::get('/author',[AuthorController::class,'index'])->name('author.index');
Route::get('/author/create',[AuthorController::class,'create'])->name('author.create');
Route::post('/author/create',[AuthorController::class,'handleCreate'])->name('author.handleCreate');

Route::get('/author/edit/{id}',[AuthorController::class,'edit'])->name('author.edit');
Route::post('/author/edit/{id}',[AuthorController::class,'update'])->name('author.update');
Route::get('/author/delete/{id}',[AuthorController::class,'destroy'])->name('author.delete');