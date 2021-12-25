<?php

use App\Events\command;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get("test",function(){
  $path = 'public/rewords/IMG-20211216-WA0006-602563884-1640358263.jpg' ;
  return Storage::size($path);
});