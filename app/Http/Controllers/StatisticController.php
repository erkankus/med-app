<?php

namespace App\Http\Controllers;

use App\Services\StatisticService;
use Illuminate\Http\Request;
use App\Models\UserMeditation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getLastSevenDayMeditation(Request $request)
    {
        // User' ın son 7 gün ve bu günlerde meditasyon yaptığı toplam süre
        $serviceResult = StatisticService::getLastSevenDayMeditation($request);

        return $this->responseJson($serviceResult);
    }





    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getMeditationCount(Request $request)
    {
        // User' ın tamamladığı toplam meditasyon sayısı
        $userMeditationCount = UserMeditation::where('user_id', $request->user()->id)
                                             ->where('created_at', '>=', $request->start_date)
                                             ->where('created_at', '<=', $request->end_date)
                                             ->where('completed', $request->completed)
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
        // User' ın toplam meditasyon yaptığı süre
        $userMeditationTotalTime = UserMeditation::selectRaw('time(sum(meditations.time)) as total')
                                                 ->join('meditations', 'user_meditations.meditation_id', 'meditations.id')
                                                 ->where('user_meditations.user_id', $request->user()->id)
                                                 ->where('user_meditations.completed', $request->completed)
                                                 ->where('user_meditations.created_at', '>=', $request->start_date)
                                                 ->where('user_meditations.created_at', '<=', $request->end_date)
                                                 ->first('total');

        $userMeditationTotalTime = isset($userMeditationTotalTime) ? $userMeditationTotalTime->total : 0;

        return response()->json([
            'success' => true,
            'data' => [
                'total_time' => $userMeditationTotalTime
            ],
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getMeditationTopCount(Request $request)
    {
        // User' ın hiç ara vermeden en fazla kaç gün üst üste meditasyon tamamladığı sayısı
        $userMeditations = UserMeditation::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
                                         ->where('user_id', $request->user()->id)
                                         ->where('completed', $request->completed)
                                         ->where('created_at', '>=', $request->start_date)
                                         ->where('created_at', '<=', $request->end_date)
                                         ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                                         ->orderBy('created_at')
                                         ->get();

        $count = 0;

        if (!is_null($userMeditations)) {
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

        $meditationTopCountResult = $count;

        return response()->json([
            'success' => true,
            'data' => [
                'meditation_top_count' => $meditationTopCountResult
            ],
        ]);
    }
}
