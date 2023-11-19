<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AdminsController;

// admin - viet thanh
Route::get('/admin/login',[AdminsController::class,'login'])->name('admin.login')->middleware('guest');
Route::post('/admin/login-handler', [AdminsController::class, 'loginHandler'])->name('admin.loginHandler');
Route::get('/admin/logout', [AdminsController::class, 'logout'])->name('admin.logout');
Route::get('/admin',[AdminsController::class,'index'])->name('admin.index')->middleware('auth'); 
Route::get('/admin/create', [AdminsController::class, 'create'])->name('admin.create')->middleware('auth');
Route::post('/admin/store', [AdminsController::class, 'store'])->name('admin.store')->middleware('auth');   