<?php

use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use App\Models\Reservation;
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


Route::get('loginrequired', function () {
    return response()->json('loginrequired',202);
})->name('login');


//only auth
Route::middleware(['auth:api'])
->group(function () {

    //logout api
    Route::post('logout', [LoginController::class,'logout']);

    //for client
    Route::prefix('client')
    ->group(function(){
        //gifts
        Route::get('commandes', [ShopController::class,'getGifts']);
        Route::post('shop', [ShopController::class,'shop']);
        Route::post('commandes/detail', [GiftController::class,'get_gifts_byId']);
        //orders
        Route::get('orders', [CommandeController::class,'getOrders']);
        Route::post('order', [CommandeController::class,'clientOrder']);
        Route::post('orders/detail', [ProductController::class,'get_orders_byId']);
        //reservations
        Route::get('tables', [TableController::class,'getTables']);
        Route::get('reservations', [ReservationController::class,'getReservations']);
        Route::post('reserve', [ReservationController::class,'reserve']);
    });

    //account settings for client
    Route::prefix(('account'))
    ->group(function () {
        Route::post('password-update', [UserController::class,'password_update']);
        Route::post('personal-update', [ClientController::class,'information_update']);
    });

    //for admin
    Route::middleware(['admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('get-tables',[TableController::class,'getTables']);
        Route::get('get-table-info',[TableController::class,'tableInformation']);
        Route::post('create-table',[TableController::class,'createTable']);
        Route::post('create-employer',[EmployerController::class,'createEmployer']);
        Route::delete('delete-table',[TableController::class,'deleteTable']);
        Route::delete('delete-employer',[EmployerController::class,'deleteEmployer']);
        Route::put('update-password',[TableController::class,'updatePassword']);
    });

});

    //login api
    Route::prefix('auth')
    ->group(function(){
        Route::post('login', [LoginController::class,'login']);
        Route::post('register', [LoginController::class,'register']);
    });

    // gifts api
    Route::prefix('gifts')
    ->group(function(){
        Route::get('/', [GiftController::class,'get_gifts']);
        Route::get('filter', [GiftController::class,'get_gifts_filter']);
    });

    //menu api
    Route::prefix('menu')
    ->group(function(){
        Route::get('/', [CategoryProductController::class,'get_menu']);
        Route::get('product', [ProductController::class,'get_product_category']);
    });



