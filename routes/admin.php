<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StaticBlockController;
use App\Http\Controllers\Admin\StaticPageController;

require __DIR__ . '/auth.php';
Route::prefix('admin')->group(function () {
    Route::middleware(['auth', 'admin'])->group(function () {
        route::get('dashboard', [HomeController::class, 'index']);

        route::get('view_category', [CategoryController::class, 'view_category']);

        route::post('add_category', [CategoryController::class, 'add_category']);

        route::get('delete_category/{id}', [CategoryController::class, 'delete_category']);

        route::get('edit_category/{id}', [CategoryController::class, 'edit_category']);

        route::post('update_category/{id}', [CategoryController::class, 'update_category']);

        route::get('deleted_categories', [CategoryController::class, 'deleted_categories']);


        route::get('restore_category/{id}', [CategoryController::class, 'restore_category']);

        route::delete('force_delete_category/{id}', [CategoryController::class, 'force_delete_category']);
        route::get('add_product', [AdminProductController::class, 'add_product']);

        route::post('upload_product', [AdminProductController::class, 'upload_product']);

        Route::get('view_product', [AdminProductController::class, 'view_product']);

        Route::get('delete_product/{id}', [AdminProductController::class, 'delete_product']);

        Route::get('edit_product/{id}', [AdminProductController::class, 'edit_product']);

        Route::post('update_product/{id}', [AdminProductController::class, 'update_product']);

        Route::get('deleted_products', [AdminProductController::class, 'deleted_products']);

        Route::get('restore_product/{id}', [AdminProductController::class, 'restore_product']);

        Route::delete('force_delete_product/{id}', [AdminProductController::class, 'force_delete_product']);

        Route::get('view_orders', [OrderController::class, 'view_orders']);

        Route::get('on_the_way/{id}', [OrderController::class, 'on_the_way']);

        Route::get('delivered/{id}', [OrderController::class, 'delivered']);

        Route::get('print_pdf/{id}', [OrderController::class, 'print_pdf']);
    });

    
    Route::prefix('blocks')->group(function () {
            Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [StaticBlockController::class, 'index'])->name('admin.blocks.index');

        Route::get('/create', [StaticBlockController::class, 'create'])->name('admin.blocks.create');
        Route::post('/create', [StaticBlockController::class, 'store'])->name('admin.blocks.store');

        Route::get('/{slug}/edit', [StaticBlockController::class, 'edit'])->name('admin.blocks.edit');
        Route::patch('/{slug}/update', [StaticBlockController::class, 'update'])->name('admin.blocks.update');

        Route::delete('/{slug}/delete', [StaticBlockController::class, 'destroy'])->name('admin.blocks.delete');
    });
    });
    Route::prefix('pages')->group(function () {
                Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [StaticPageController::class, 'index'])->name('admin.pages.index');

        Route::get('/create', [StaticPageController::class, 'create'])->name('admin.pages.create');
        Route::post('/create', [StaticPageController::class, 'store'])->name('admin.pages.store');

        Route::get('/{slug}/edit', [StaticPageController::class, 'edit'])->name('admin.pages.edit');
        Route::patch('/{slug}/update', [StaticPageController::class, 'update'])->name('admin.pages.update');

        Route::delete('/{slug}/delete', [StaticPageController::class, 'destroy'])->name('admin.pages.delete');
    });
    });
});
