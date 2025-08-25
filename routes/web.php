<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/category/{slug}', [CatalogController::class, 'index'])->name('category.show');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');

Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/login', function () {
    return view('auth.auth');
})->name('login');

Route::get('/login', function () {
    return view('auth.auth');
})->name('login');

