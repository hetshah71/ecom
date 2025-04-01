<?php

@include('admin.php');

use App\Http\Controllers\StaticPageController as StaticPageUser;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('/dashboard', [HomeController::class, 'login_home'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('product_details/{slug}', [HomeController::class, 'product_details']);

Route::get('add_cart/{id}', [CartController::class, 'add_cart'])->middleware((['auth', 'verified']));

Route::get('mycart', [CartController::class, 'mycart'])->middleware((['auth', 'verified']));

Route::delete('remove_cart/{id}', [CartController::class, 'remove_cart'])->name('remove_cart')->middleware((['auth', 'verified']));

Route::post('confirm_order', [CartController::class, 'confirm_order'])->name('confirm_order')->middleware((['auth', 'verified']));

Route::get('/myorders', [OrderController::class, 'show'])->middleware(['auth', 'verified'])->name('myorders');
Route::get('/invoice/{invoice_no}', [OrderController::class, 'showInvoice'])->name('show.invoice');
Route::get('/invoice/{invoice_no}/download', [OrderController::class, 'downloadInvoice'])->name('download.invoice');


Route::get('shop', [HomeController::class, 'shop'])->name('shop');

Route::get('why', [HomeController::class, 'why']);

Route::get('contact', [HomeController::class, 'contact']);

Route::get('testimonial', [HomeController::class, 'testimonial']);

Route::get('terms', [StaticPageUser::class, 'show'])->name('terms');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');



// Order Routes
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
