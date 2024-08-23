<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FilterController;


Auth::routes();

Route::get('/', [FrontendController::class, 'index'])->name('Index');
Route::get('/search/for/products', [FrontendController::class, 'searchForProducts'])->name('SearchForProducts');
Route::post('/product/quick/view', [FrontendController::class, 'productQuickView'])->name('ProductQuickView');
Route::post('check/product/variant', [FrontendController::class, 'checkProductVariant'])->name('CheckProductVariant');
Route::get('/shop', [FrontendController::class, 'shop'])->name('Shop');
Route::post('/filter/products', [FilterController::class, 'filterProducts'])->name('FilterProducts');

// blog routes
Route::get('/blogs', [BlogController::class, 'blogs'])->name('Blogs');
Route::get('/blog/category/{slug}', [BlogController::class, 'blogCategory'])->name('BlogCategory');
Route::get('/blog/details/{slug}', [BlogController::class, 'blogDetails'])->name('BlogDetails');

// cart
Route::get('add/to/cart/{id}', [CartController::class, 'addToCart'])->name('AddToCart');
Route::post('add/to/cart/with/qty', [CartController::class, 'addToCartWithQty'])->name('AddToCartWithQty');
Route::get('remove/cart/item/{id}', [CartController::class, 'removeCartTtem'])->name('RemoveCartTtem');
Route::post('update/cart/qty', [CartController::class, 'updateCartQty'])->name('UpdateCartQty');
Route::get('view/cart', [CartController::class, 'viewCart'])->name('ViewCart');
Route::get('clear/cart', [CartController::class, 'clearCart'])->name('ClearCart');


Route::get('/home', [HomeController::class, 'index'])->name('home');
