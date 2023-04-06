<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactFormApiController;
use App\Http\Controllers\Api\BookingFormApiController;
# Headers To resolve Cors Error
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::POST('/contactform/store', [ContactFormApiController::class, 'store']);
Route::POST('/bookingform/store', [BookingFormApiController::class, 'store']);
Route::POST('/medicalform/store', 'App\Http\Controllers\Api\MedicalFormController@store');
