<?php

namespace App\Services;

use App\Constants\GlobalConstant;
use App\Helpers\GlobalHelper;
use App\Models\UserMeditation;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Results\ServiceResult;
use Illuminate\Support\Facades\Validator;

class StatisticService
{
    /**
     * @param Request $request
     * @return ServiceResult
     */
    public static function getLastSevenDayMeditation(Request $request): ServiceResult
    {
        $serviceResult = new ServiceResult();

        $dateSevenDayAgo = GlobalHelper::dateDayBefore(GlobalConstant::DAY_SEVEN);

        $lastSevenDayMeditations = UserMeditation::selectRaw("time(sum(meditations.time)) as total_time, DATE_FORMAT(user_meditations.created_at, '%Y-%m-%d') as date")
            ->join('meditations', 'user_meditations.meditation_id', 'meditations.id')
            ->where('user_meditations.user_id', $request->user()->id)
            ->where('user_meditations.completed', GlobalConstant::COMPLETED)
            ->where('user_meditations.created_at', '>=', $dateSevenDayAgo)
            ->groupBy(DB::raw("DATE_FORMAT(user_meditations.created_at, '%Y-%m-%d')"))
            ->orderBy('user_meditations.created_at')
            ->get();

        $lastSevenDayMeditationResult = is_null($lastSevenDayMeditations) ? array() : $lastSevenDayMeditations->toArray();

        $data = [
            'last_seven_day_meditation' => $lastSevenDayMeditationResult
        ];

        $serviceResult->setSuccess(true);
        $serviceResult->setData($data);

        return $serviceResult;
    }

    /**
     * @param Request $request
     * @return ServiceResult
     */
    public static function getMeditationCount(Request $request)
    {
        $serviceResult = new ServiceResult();

        // Validation
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'completed' => 'required',
        ]);

        if ($validator->fails()) {
            $serviceResult->setSuccess(false);
            $serviceResult->setMessage($validator->errors()->first());
            return $serviceResult;
        }

        // User' ın meditasyon tamamladığı süre veritabanından çekiliyor
        $userMeditationCount = UserMeditation::where('user_id', $request->user()->id)
            ->where('created_at', '>=', $request->start_date)
            ->where('created_at', '<=', $request->end_date)
            ->where('completed', $request->completed)
            ->count();

        $userMeditationCount = is_null($userMeditationCount) ? 0 : $userMeditationCount;

        $data = [
            'meditation_count' => $userMeditationCount
        ];

        $serviceResult->setSuccess(true);
        $serviceResult->setData($data);

        return $serviceResult;
    }

    /**
     * @param Request $request
     * @return ServiceResult
     */
    public static function getMeditationTotalTime(Request $request)
    {
        $serviceResult = new ServiceResult();

        // Validation
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'completed' => 'required',
        ]);

        if ($validator->fails()) {
            $serviceResult->setSuccess(false);
            $serviceResult->setMessage($validator->errors()->first());
            return $serviceResult;
        }

        // User' ın toplam meditasyon yaptığı süre
        $userMeditationTotalTime = UserMeditation::selectRaw('time(sum(meditations.time)) as total')
            ->join('meditations', 'user_meditations.meditation_id', 'meditations.id')
            ->where('user_meditations.user_id', $request->user()->id)
            ->where('user_meditations.completed', $request->completed)
            ->where('user_meditations.created_at', '>=', $request->start_date)
            ->where('user_meditations.created_at', '<=', $request->end_date)
            ->first('total');

        $userMeditationTotalTime = isset($userMeditationTotalTime) ? $userMeditationTotalTime->total : 0;

        $data = [
            'meditation_total_time' => $userMeditationTotalTime
        ];

        $serviceResult->setSuccess(true);
        $serviceResult->setData($data);

        return $serviceResult;
    }

    /**
     * @param Request $request
     * @return ServiceResult
     */
    public static function getMeditationTopCount(Request $request)
    {
        $serviceResult = new ServiceResult();

        // Validation
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'completed' => 'required',
        ]);

        if ($validator->fails()) {
            $serviceResult->setSuccess(false);
            $serviceResult->setMessage($validator->errors()->first());
            return $serviceResult;
        }

        $userMeditations = UserMeditation::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"))
            ->where('user_id', $request->user()->id)
            ->where('completed', $request->completed)
            ->where('created_at', '>=', $request->start_date)
            ->where('created_at', '<=', $request->end_date)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
            ->orderBy('created_at')
            ->get();

        $count = GlobalConstant::ZERO;

        if (!is_null($userMeditations)) {
            $meditations = $userMeditations->pluck('date')->toArray();
            $firstDate = Arr::first($meditations);

            $count = GlobalConstant::ONE;
            $nextDate = $firstDate;

            foreach ($meditations as $meditation) {
                $nextDate = GlobalHelper::dateDayAfter($nextDate, GlobalConstant::DAY_ONE, GlobalConstant::DATE_FORMAT);

                if (in_array($nextDate, $meditations)) {
                    $count++;
                } else {
                    $count = GlobalConstant::ONE;
                }
            }
        }

        $data = [
            'meditation_top_count' => $count
        ];

        $serviceResult->setSuccess(true);
        $serviceResult->setData($data);

        return $serviceResult;
    }
}
