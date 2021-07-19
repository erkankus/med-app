<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;

Route::post("login", [AuthController::class, 'postLogin']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post("meditation-count", [StatisticController::class, 'getMeditationCount']);
    Route::post("meditation-total-time", [StatisticController::class, 'getMeditationTotalTime']);
    Route::post("meditation-top-count", [StatisticController::class, 'getMeditationTopCount']);
    Route::post("last-seven-day-meditation", [StatisticController::class, 'getLastSevenDayMeditation']);
});
