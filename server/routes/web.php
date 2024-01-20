<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\GoodsReceivedNoteController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ComboController;

//auth-Viet Thanh
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login')->middleware('guest');
Route::post('/admin/login-handler', [AdminController::class, 'loginHandler'])->name('admin.loginHandler');

Route::middleware('auth')->group(function () {
    //dashboard-viet Thanh
    Route::get('/', [DashboardController::class, 'overview'])->name('dashboard.index');
    Route::get('/order-chart', [DashboardController::class, 'getChart'])->name('dashboard.chart');
    Route::get('/hot-selling', [DashboardController::class, 'hotSelling'])->name('dashboard.hot.selling');
    Route::post('/filter-order', [DashboardController::class, 'filterOrder'])->name('dashboard.filter.order');
    //admin-Viet thanh
    Route::prefix('admin')->group(function () {
        Route::name('admin.')->group(function () {
            Route::get('logout', [AdminController::class, 'logout'])->name('logout');
            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::get('profile', [AdminController::class, 'profile'])->name('profile');
            Route::get('data-table', [AdminController::class, 'dataTable'])->name('data.table');
            Route::post('import-admins', [AdminController::class, 'import'])->name('import');
            Route::get('create', [AdminController::class, 'create'])->name('create');
            Route::post('store', [AdminController::class, 'store'])->name('store');
            Route::get('edit/{id}', [AdminController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [AdminController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [AdminController::class, 'destroy'])->name('destroy');
            Route::get('trash', [AdminController::class, 'trash'])->name('trash');
            Route::get('data-table-trash', [AdminController::class, 'dataTableTrash'])->name('data.table.trash');
            Route::get('untrash/{id}', [AdminController::class, 'untrash'])->name('untrash');
        });
    });

    //combo-book-Viet thanh
    Route::prefix('combo')->group(function () {
        Route::name('combo.')->group(function () {
            Route::get('/', [ComboController::class, 'index'])->name('index');
            Route::get('data-table', [ComboController::class, 'dataTable'])->name('data.table');
            Route::get('data-table-detail/{id}', [ComboController::class, 'dataTableDetail'])->name('data.table.detail');
            Route::get('create', [ComboController::class, 'create'])->name('create');
            Route::post('store', [ComboController::class, 'store'])->name('store');
            Route::get('edit/{id}', [ComboController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [ComboController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [ComboController::class, 'destroy'])->name('destroy');
            Route::get('trash', [ComboController::class, 'trash'])->name('trash');
            Route::get('data-table-trash', [ComboController::class, 'dataTableTrash'])->name('data.table.trash');
            Route::get('untrash/{id}', [ComboController::class, 'untrash'])->name('untrash');
        });
    });
    //category-Thanh tuan
    Route::prefix('category')->group(function () {
        Route::name('category.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('data-table', [CategoryController::class, 'dataTable'])->name('data.table');
            Route::get('create', [CategoryController::class, 'create'])->name('create');
            Route::post('import-categories', [CategoryController::class, 'import'])->name('import');
            Route::post('store', [CategoryController::class, 'store'])->name('store');
            Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [CategoryController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy');
            Route::get('trash', [CategoryController::class, 'trash'])->name('trash');
            Route::get('data-table-trash', [CategoryController::class, 'dataTableTrash'])->name('data.table.trash');
            Route::get('untrash/{id}', [CategoryController::class, 'untrash'])->name('untrash');
        });
    });
    //author-Thanh Nghia
    Route::prefix('author')->group(function () {
        Route::name('author.')->group(function () {
            Route::get('/', [AuthorController::class, 'index'])->name('index');
            Route::get('data-table', [AuthorController::class, 'dataTable'])->name('data.table');
            Route::post('import-authors', [AuthorController::class, 'import'])->name('import');
            Route::get('create', [AuthorController::class, 'create'])->name('create');
            Route::post('store', [AuthorController::class, 'store'])->name('store');
            Route::get('edit/{id}', [AuthorController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [AuthorController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [AuthorController::class, 'destroy'])->name('destroy');
            Route::get('trash', [AuthorController::class, 'trash'])->name('trash');
            Route::get('data-table-trash', [AuthorController::class, 'dataTableTrash'])->name('data.table.trash');
            Route::get('untrash/{id}', [AuthorController::class, 'untrash'])->name('untrash');
        });
    });
    //supplier-Thanh Tuan
    Route::prefix('supplier')->group(function () {
        Route::name('supplier.')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('index');
            Route::get('data-table', [SupplierController::class, 'dataTable'])->name('data.table');
            Route::post('import-suppliers', [SupplierController::class, 'import'])->name('import');
            Route::get('create', [SupplierController::class, 'create'])->name('create');
            Route::post('store', [SupplierController::class, 'store'])->name('store');
            Route::get('edit/{id}', [SupplierController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [SupplierController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [SupplierController::class, 'destroy'])->name('destroy');
            Route::get('trash', [SupplierController::class, 'trash'])->name('trash');
            Route::get('data-table-trash', [SupplierController::class, 'dataTableTrash'])->name('data.table.trash');
            Route::get('untrash/{id}', [SupplierController::class, 'untrash'])->name('untrash');
        });
    });
    //goods-received-note-Thanh Tuan
    Route::prefix('goods-received-note')->group(function () {
        Route::name('goods-received-note.')->group(function () {
            Route::get('/', [GoodsReceivedNoteController::class, 'index'])->name('index');
            Route::get('show/{id}', [GoodsReceivedNoteController::class, 'show'])->name('show');
            Route::get('data-table', [GoodsReceivedNoteController::class, 'dataTable'])->name('data.table');
            Route::get('data-table-detail/{id}', [GoodsReceivedNoteController::class, 'dataTableDetail'])->name('data.table.detail');
            Route::get('create', [GoodsReceivedNoteController::class, 'create'])->name('create');
            Route::post('store', [GoodsReceivedNoteController::class, 'store'])->name('store');
            Route::get('edit/{id}', [GoodsReceivedNoteController::class, 'edit'])->name('edit');
            Route::post('update', [GoodsReceivedNoteController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [GoodsReceivedNoteController::class, 'destroy'])->name('destroy');
        });
    });
    Route::prefix('order')->group(function () {
        Route::name('order.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('data-table', [OrderController::class, 'dataTable'])->name('data.table');
            Route::get('edit-status/{id}', [OrderController::class, 'editStatus'])->name('edit.status');
            Route::post('update-status/{id}', [OrderController::class, 'updateStatus'])->name('update.status');
            Route::get('data-table-detail/{id}', [OrderController::class, 'dataTableDetail'])->name('data.table.detail');
        });
    });
    //book-Thanh Nghia
    Route::prefix('book')->group(function () {
        Route::name('book.')->group(function () {
            Route::get('/', [BookController::class, 'index'])->name('index');
            Route::get('data-table', [BookController::class, 'dataTable'])->name('data.table');
            Route::get('create', [BookController::class, 'create'])->name('create');
            Route::get('show/{id}', [BookController::class, 'show'])->name('show');
            Route::post('import-books', [BookController::class, 'import'])->name('import');
            Route::post('store', [BookController::class, 'store'])->name('store');
            Route::get('edit/{id}', [BookController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [BookController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [BookController::class, 'destroy'])->name('destroy');
            Route::get('delete-image/{id}', [BookController::class, 'deleteImage'])->name('delete.image');
            Route::get('trash', [BookController::class, 'trash'])->name('trash');
            Route::get('data-table-trash', [BookController::class, 'dataTableTrash'])->name('data.table.trash');
            Route::get('untrash/{id}', [BookController::class, 'untrash'])->name('untrash');
        });
    });
    //slider-Thanh Nghia
    Route::prefix('slider')->group(function () {
        Route::name('slider.')->group(function () {
            Route::get('/', [SliderController::class, 'index'])->name('index');
            Route::get('/data-table', [SliderController::class, 'dataTable'])->name('data.table');
            Route::get('create', [SliderController::class, 'create'])->name('create');
            Route::post('store', [SliderController::class, 'store'])->name('store');
            Route::get('edit/{id}', [SliderController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [SliderController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [SliderController::class, 'destroy'])->name('destroy');
            Route::get('trash', [SliderController::class, 'trash'])->name('trash');
            Route::get('data-table-trash', [SliderController::class, 'dataTableTrash'])->name('data.table.trash');
            Route::get('untrash/{id}', [SliderController::class, 'untrash'])->name('untrash');
        });
    });
    //publisher-Thanh Nghia
    Route::prefix('publisher')->group(function () {
        Route::name('publisher.')->group(function () {
            Route::get('/', [PublisherController::class, 'index'])->name('index');
            Route::get('data-table', [PublisherController::class, 'dataTable'])->name('data.table');
            Route::get('create', [PublisherController::class, 'create'])->name('create');
            Route::post('import-publishers', [PublisherController::class, 'import'])->name('import');
            Route::post('store', [PublisherController::class, 'store'])->name('store');
            Route::get('edit/{id}', [PublisherController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [PublisherController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [PublisherController::class, 'destroy'])->name('destroy');
            Route::get('trash', [PublisherController::class, 'trash'])->name('trash');
            Route::get('data-table-trash', [PublisherController::class, 'dataTableTrash'])->name('data.table.trash');
            Route::get('untrash/{id}', [PublisherController::class, 'untrash'])->name('untrash');
        });
    });

    //customer-Viet thanh
    Route::prefix('customer')->group(function () {
        Route::name('customer.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('data-table', [CustomerController::class, 'dataTable'])->name('data.table');
        });
    });

    //discount-Viet thanh
    Route::prefix('discount')->group(function () {
        Route::name('discount.')->group(function () {
            Route::get('/', [DiscountController::class, 'index'])->name('index');
            Route::get('data-table', [DiscountController::class, 'dataTable'])->name('data.table');
            Route::post('store', [DiscountController::class, 'store'])->name('store');
            Route::get('edit/{id}', [DiscountController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [DiscountController::class, 'update'])->name('update');
            Route::post('destroy/{id}', [DiscountController::class, 'destroy'])->name('destroy');
            Route::get('trash', [DiscountController::class, 'trash'])->name('trash');
            Route::get('data-table-trash', [DiscountController::class, 'dataTableTrash'])->name('data.table.trash');
            Route::get('untrash/{id}', [DiscountController::class, 'untrash'])->name('untrash');
        });
    });

    Route::prefix('comment')->group(function () {
        Route::name('comment.')->group(function () {
            Route::get('/', [CommentController::class, 'index'])->name('index');
            Route::get('data-table', [CommentController::class, 'dataTable'])->name('data.table');
            Route::get('data-table-detail/{id}', [CommentController::class, 'dataTableDetail'])->name('data.table.detail');
            Route::post('destroy/{id}', [CommentController::class, 'destroy'])->name('destroy');
            Route::post('destroy-reply/{id}', [CommentController::class, 'destroyReply'])->name('destroy.reply');
        });
    });

    Route::prefix('review')->group(function () {
        Route::name('review.')->group(function () {
            Route::get('/', [ReviewController::class, 'index'])->name('index');
            Route::get('data-table', [ReviewController::class, 'dataTable'])->name('data.table');
            Route::get('update/{id}', [ReviewController::class, 'update'])->name('update');
            Route::get('update-status/{id}', [ReviewController::class, 'updateStatus'])->name('update.status');
            Route::get('destroy/{id}', [ReviewController::class, 'destroy'])->name('destroy');
        });
    });
});




