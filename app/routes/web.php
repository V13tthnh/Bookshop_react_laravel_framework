<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\AdminsController;
use  App\Http\Controllers\CategoriesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login',[AdminsController::class,'login'])->name('admin.login');
Route::get('/',[AdminsController::class,'index'])->name('admin.index');

Route::get('/admin/categories/list',[CategoriesController::class,'show'])->name('admin.index');
Route::get('/admin/categories/add',[CategoriesController::class,'create'])->name('admin.categories');
Route::post('/admin/categories/add',[CategoriesController::class,'actionCreate'])->name('admin.categories.add');
Route::get('/admin/categories/edit/{id}',[CategoriesController::class,'edit'])->name('admin.categories.edit');
Route::post('/admin/categories/edit/{id}',[CategoriesController::class,'editHandle'])->name('admin.categories.edit');
Route::get('/admin/categories/delete/{id}',[CategoriesController::class,'deleteHandle'])->name('admin.categories.delete');