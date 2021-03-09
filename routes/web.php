<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/auth/instagram/callback',[\App\Http\Controllers\InstagramControllers\InstagramController::class, 'authorizeInstagram'])->name('authorizeInstagram');
Route::get('/', [\App\Http\Controllers\ShopifyControllers\HomeController::class, 'viewHomePage'])->middleware(['auth.shopify'])->name('home');
