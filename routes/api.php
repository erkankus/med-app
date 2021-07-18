<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatisticController;

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

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post("meditation-count", [StatisticController::class, 'getMeditationCount']);
    Route::post("meditation-total-time", [StatisticController::class, 'getMeditationTotalTime']);
    Route::post("meditation-top-count", [StatisticController::class, 'getMeditationTopCount']);
    Route::post("last-week-meditation-time", [StatisticController::class, 'getLastWeekMeditationTime']);
});

Route::post("login", [UserController::class, 'postLogin']);
