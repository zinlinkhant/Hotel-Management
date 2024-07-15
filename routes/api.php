<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\HotelBookController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('guests', [GuestController::class, 'index']);
Route::post('guests', [GuestController::class, 'store']);





Route::get('hotel-books', [HotelBookController::class, 'index']);
Route::post('hotel-books', [HotelBookController::class, 'store']);


Route::get('rooms', [RoomController::class, 'index']);
Route::post('rooms', [RoomController::class, 'store']);
