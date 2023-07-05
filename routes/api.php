<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\DrivingController;
use App\Http\Controllers\TripController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('submit', [LoginController::class, 'submit']);
Route::post('verify', [LoginController::class, 'verify']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('store', [DriverController::class, 'store']);
    Route::post('registerTrip', [TripController::class, 'registerTrip']);
    Route::post('accept', [TripController::class, 'accept']);
    Route::post('end', [TripController::class, 'end']);
    Route::post('start', [TripController::class, 'start']);
    Route::get('show', [TripController::class, 'show']);
});
