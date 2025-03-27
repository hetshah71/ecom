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

    route::get('dashboard', [HomeController::class, 'index'])->middleware((['auth', 'admin']));

    route::get('view_category', [CategoryController::class, 'view_category'])->middleware((['auth', 'admin']));

    route::post('add_category', [CategoryController::class, 'add_category'])->middleware((['auth', 'admin']));

    route::get('delete_category/{id}', [CategoryController::class, 'delete_category'])->middleware((['auth', 'admin']));

    route::get('edit_category/{id}', [CategoryController::class, 'edit_category'])->middleware((['auth', 'admin']));

    route::post('update_category/{id}', [CategoryController::class, 'update_category'])->middleware((['auth', 'admin']));

    route::get('add_product', [AdminProductController::class, 'add_product'])->middleware((['auth', 'admin']));

    route::post('upload_product', [AdminProductController::class, 'upload_product'])->middleware((['auth', 'admin']));

    Route::get('view_product', [AdminProductController::class, 'view_product'])->middleware((['auth', 'admin']));

    Route::get('delete_product/{id}', [AdminProductController::class, 'delete_product'])->middleware((['auth', 'admin']));

    Route::get('edit_product/{id}', [AdminProductController::class, 'edit_product'])->middleware((['auth', 'admin']));

    Route::post('update_product/{id}', [AdminProductController::class, 'update_product'])->middleware((['auth', 'admin']));

    Route::get('view_orders', [OrderController::class, 'view_orders'])->middleware((['auth', 'admin']));

    Route::get('on_the_way/{id}', [OrderController::class, 'on_the_way'])->middleware((['auth', 'admin']));

    Route::get('delivered/{id}', [OrderController::class, 'delivered'])->middleware((['auth', 'admin']));

    Route::get('print_pdf/{id}', [OrderController::class, 'print_pdf'])->middleware((['auth', 'admin']));

    Route::prefix('blocks')->group(function () {
        Route::get('/', [StaticBlockController::class, 'index'])->name('admin.blocks.index');

        Route::get('/create', [StaticBlockController::class, 'create'])->name('admin.blocks.create');
        Route::post('/create', [StaticBlockController::class, 'store'])->name('admin.blocks.store');

        Route::get('/{slug}/edit', [StaticBlockController::class, 'edit'])->name('admin.blocks.edit');
        Route::patch('/{slug}/update', [StaticBlockController::class, 'update'])->name('admin.blocks.update');

        Route::delete('/{slug}/delete', [StaticBlockController::class, 'destroy'])->name('admin.blocks.delete');
    });
    
    Route::prefix('pages')->group(function () {
        Route::get('/', [StaticPageController::class, 'index'])->name('admin.pages.index');

        Route::get('/create', [StaticPageController::class, 'create'])->name('admin.pages.create');
        Route::post('/create', [StaticPageController::class, 'store'])->name('admin.pages.store');

        Route::get('/{slug}/edit', [StaticPageController::class, 'edit'])->name('admin.pages.edit');
        Route::patch('/{slug}/update', [StaticPageController::class, 'update'])->name('admin.pages.update');

        Route::delete('/{slug}/delete', [StaticPageController::class, 'destroy'])->name('admin.pages.delete');
    });
});
