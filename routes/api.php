<?php

use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ShopDetailController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use App\Models\Gift;
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

Route::middleware(['auth:api','admin'])
->group(function () {


});

Route::middleware(['auth:api'])
->group(function () {
    Route::post('client/shop', [ShopController::class,'shop']);
    Route::get('client/commandes', [ShopController::class,'getGifts']);
    Route::post('client/commandes/detail', [GiftController::class,'get_gifts_byId']);
});

Route::middleware('auth:api')
->prefix('account')
->group(function () {
    Route::post('password-update', [UserController::class,'password_update']);
    Route::post('personal-update', [ClientController::class,'information_update']);
});



Route::get('loginrequired', function () {
    return response()->json('loginrequired',202);
})->name('login');

Route::prefix('auth')
    ->group(function(){
    Route::post('login', [LoginController::class,'login']);
    Route::post('register', [LoginController::class,'register']);
    Route::post('logout', [LoginController::class,'logout'])->middleware('auth:api');
});

Route::prefix('gifts')
    ->group(function(){
        Route::get('/', [GiftController::class,'get_gifts']);
        Route::get('filter', [GiftController::class,'get_gifts_filter']);
});

Route::prefix('menu')
    ->group(function(){
        Route::get('/', [CategoryProductController::class,'get_menu']);
        Route::get('product', [ProductController::class,'get_product_category']);
});

