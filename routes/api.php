<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FingerSpotController;
use App\Http\Controllers\SendMessageController;
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
Route::get('attlog',[FingerSpotController::class,'GetAttandance']);
Route::get('sendabsennotification/{id}',[SendMessageController::class,'SendAbsenNotification']);
Route::post('/attwebhook', [FingerSpotController::class, 'RealtimeAttandance'])->name('attwebhook');