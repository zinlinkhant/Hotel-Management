<?php

use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HotelBookController;
use App\Http\Controllers\InvetoryController;
use App\Http\Controllers\ReviewsController;
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
Route::patch('guests/{id}', [GuestController::class, 'update']);
Route::delete('guests/{id}', [GuestController::class, 'destroy']);

Route::get('hotel-books', [HotelBookController::class, 'index']);
Route::post('hotel-books', [HotelBookController::class, 'store']);
Route::patch('hotel-books/{id}', [HotelBookController::class, 'update']);
Route::delete('hotel-books/{id}', [HotelBookController::class, 'destroy']);

Route::get('rooms', [RoomController::class, 'index']);
Route::post('rooms', [RoomController::class, 'store']);
Route::patch('rooms/{id}', [RoomController::class, 'update']);
Route::delete('rooms/{id}', [RoomController::class, 'destroy']);

Route::get('check-outs', [CheckOutController::class, 'index']);
Route::post('check-outs', [CheckOutController::class, 'store']);
Route::patch('check-outs/{id}', [CheckOutController::class, 'update']);
Route::delete('check-outs/{id}', [CheckOutController::class, 'destroy']);

Route::get('reviews', [ReviewsController::class, 'index']);
Route::post('reviews', [ReviewsController::class, 'store']);
Route::patch('reviews/{id}', [ReviewsController::class, 'update']);
Route::delete('reviews/{id}', [ReviewsController::class, 'destroy']);

Route::get('invetories', [InvetoryController::class, 'index']);
Route::post('invetories', [InvetoryController::class, 'store']);
Route::patch('invetories/{id}', [InvetoryController::class, 'update']);
Route::delete('invetories/{id}', [InvetoryController::class, 'destroy']);
