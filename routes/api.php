<?php

use App\Events\command;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CommandeDetailController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use App\Models\Reservation;
use App\Models\User;
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
        Route::delete('delete-table',[TableController::class,'deleteTable']);
        Route::put('update-password',[TableController::class,'updatePassword']);

        Route::post('create-employer',[EmployerController::class,'createEmployer']);
        Route::delete('delete-employer',[EmployerController::class,'deleteEmployer']);
        Route::get('get-employers',[EmployerController::class,'getEmployers']);
        Route::get('get-employerById',[EmployerController::class,'employerById']);

        Route::get('InComeStat',[CommandeDetailController::class,'InComeStat']);
        Route::get('get-gift-stock',[GiftController::class,'get_gifts']);
        Route::get('get-product-stock',[ProductController::class,'getProductStock']);
        Route::patch('update-product',[ProductController::class,'updateProduct']);
        Route::patch('update-gift',[GiftController::class,'updateGift']);
    });

    //for table
    Route::middleware([])
    ->prefix('table')
    ->group(function () {
        Route::post('logout',[TableController::class,'logoutCheck']);
        Route::post('buy',[CommandeController::class,'buy']);
    });


    //for employer
    Route::middleware([])
    ->prefix('employer')
    ->group(function () {
        Route::get('get-reservations',[TableController::class,'getReservations']);
        Route::get('get-commands',[CommandeController::class,'getCommands_Employer']);
        Route::post('get-products',[ProductController::class,'getProducts_Employer']);
        Route::get('get-stat',[CommandeController::class,'getStat_Employer']);
        Route::patch('command-action',[CommandeController::class,'command_action']);
        Route::get('get-detail',[CommandeDetailController::class,'getDetail']);
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



