<?php

namespace App\Services;

use App\Constants\GlobalConstant;
use App\Helpers\GlobalHelper;
use App\Models\UserMeditation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Results\ServiceResult;

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

        $serviceResult->setSuccess(true);
        $serviceResult->setData($lastSevenDayMeditationResult);

        return $serviceResult;
    }
}
