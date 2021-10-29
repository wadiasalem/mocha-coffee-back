<?php

use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\Admin;
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

Route::middleware(['auth:api','admin'])->group(function () {
    Route::get('product', [CategoryProductController::class,'getall']);
});

Route::get('loginrequired', function () {
    return response()->json('loginrequired',202);
})->name('login');

Route::post('login', [LoginController::class,'login']);
Route::post('register', [LoginController::class,'register']);
