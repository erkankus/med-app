<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMeditation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getMeditationCount(Request $request)
    {
        // User' ın tamamladığı toplam meditasyon sayısı
        $userMeditationCount = UserMeditation::where('user_id', $request->user()->id)
                                             ->where('completed', 'Y')
                                             ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'count' => $userMeditationCount
            ],
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getMeditationTotalTime(Request $request)
    {
        // userın toplam meditasyon yaptığı süre
        $userMeditationTotalTime = UserMeditation::selectRaw('time(sum(meditations.time)) as total')
                                                 ->join('meditations', 'user_meditations.meditation_id', 'meditations.id')
                                                 ->where('user_meditations.user_id', $request->user()->id)
                                                 ->where('user_meditations.completed', 'Y')
                                                 ->first('total');

        return response()->json([
            'success' => true,
            'data' => [
                'time' => $userMeditationTotalTime->total
            ],
        ]);
    }

    function getMeditationTopCount(Request $request)
    {
        // userın hiç ara vermeden en fazla kaç gün üst üste meditasyon tamamladığı sayısı
        $userMeditations = UserMeditation::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
                                         ->where('completed', 'Y')
                                         ->where('user_id', $request->user()->id)
                                         ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                                         ->orderBy('created_at')
                                         ->get();

        $count = 0;

        if ($userMeditations) {
            $meditationArr = $userMeditations->pluck('date')->toArray();
            $firstDay = Arr::first($meditationArr);

            $count = 1;
            $nextDate = $firstDay;

            foreach ($meditationArr as $meditation) {
                $dayAfter = strtotime('1 day',strtotime($nextDate));
                $nextDate =  date('Y-m-d', $dayAfter);

                if (in_array($nextDate, $meditationArr)) {
                    $count++;
                } else {
                    $count = 1;
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'count' => $count
            ],
        ]);
    }

    function getLastWeekMeditationTime(Request $request)
    {
        // userın son 7 gün ve bu günlerde meditasyon yaptığı süre

        $dayAfter = strtotime('-7 day',strtotime(date('Y-m-d H:i:s')));
        $date = date('Y-m-d', $dayAfter);

        $userMeditationTotalTime = UserMeditation::selectRaw("time(sum(meditations.time)) as total_time, DATE_FORMAT(user_meditations.created_at, '%Y-%m-%d') as date")
                                                 ->join('meditations', 'user_meditations.meditation_id', 'meditations.id')
                                                 ->where('user_meditations.user_id', $request->user()->id)
                                                 ->where('user_meditations.completed', 'Y')
                                                 ->where('user_meditations.created_at', '>=', $date)
                                                 ->groupBy(DB::raw("DATE_FORMAT(user_meditations.created_at, '%Y-%m-%d')"))
                                                 ->orderBy('user_meditations.created_at')
                                                 ->get();

        return response()->json([
            'success' => true,
            'data' => $userMeditationTotalTime->toArray()
        ]);
    }

}
