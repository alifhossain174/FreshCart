<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;

Auth::routes();

Route::get('/', [FrontendController::class, 'index'])->name('Index');

Route::get('/home', [HomeController::class, 'index'])->name('home');
