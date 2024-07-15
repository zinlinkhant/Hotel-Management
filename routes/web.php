<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\HotelBookController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::resource('guests', GuestController::class);
Route::get('guests', [GuestController::class, 'index']);
Route::post('guests', [GuestController::class, 'store']);





Route::get('hotel-books', [HotelBookController::class, 'index']);
Route::post('hotel-books', [HotelBookController::class, 'store']);


Route::get('rooms', [RoomController::class, 'index']);
Route::post('rooms', [RoomController::class, 'store']);
