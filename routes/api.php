<?php

use App\Http\Controllers\BookingController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.v1.')->group(function () {

    Route::prefix('bookings')->name('bookings.')->group(function () {

        Route::get('', [BookingController::class, 'index'])->name('index');
        Route::post('', [BookingController::class, 'store'])->name('store');

    });

});
