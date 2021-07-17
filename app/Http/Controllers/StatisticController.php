<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StatisticController extends Controller
{
    function getMeditationCount(Request $request)
    {
        // userın tamamladığı meditasyon sayısı

    }

    function getMeditationTotalTime(Request $request)
    {
        // userın toplam meditasyon yaptığı süre

    }

    function getMeditationTopCount(Request $request)
    {
        // userın hiç ara vermeden en fazla kaç gün üst üste meditasyon tamamladığı sayısı

    }

    function getLastWeekMeditationTime(Request $request)
    {
        // userın son 7 gün ve bu günlerde meditasyon yaptığı süre

    }

}
