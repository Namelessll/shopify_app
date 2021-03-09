<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('/instagram/posts',[\App\Http\Controllers\ApiController::class, 'get'])->name('getPosts');


Route::get('/popup', [\App\Http\Controllers\APIController::class, 'popupData'])->name('popupData');
Route::post('/item/publish', [\App\Http\Controllers\APIController::class, 'publishItem'])->name('publishItem');
Route::post('/item/unpublish', [\App\Http\Controllers\APIController::class, 'UnPublishItem'])->name('UnPublishItem');


Route::get('/admin/shop/products', [\App\Http\Controllers\APIController::class, 'getProducts'])->name('getProducts');

Route::post('/item/image/dot/set', [\App\Http\Controllers\APIController::class, 'setDot'])->name('setDot');
Route::post('/item/image/dot/unset', [\App\Http\Controllers\APIController::class, 'unsetDot'])->name('unsetDot');
Route::post('/item/image/dot/update', [\App\Http\Controllers\APIController::class, 'updateDot'])->name('updateDot');
