<?php

namespace App\Http\Controllers;

use App\Services\StatisticService;
use Illuminate\Http\Request;

/**
 * Class StatisticController
 * @package App\Http\Controllers
 */
class StatisticController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getLastSevenDayMeditation(Request $request)
    {
        // TODO: User' ın son 7 gün ve bu günlerde meditasyon yaptığı toplam süre
        $serviceResult = StatisticService::getLastSevenDayMeditation($request);

        return $this->responseJson($serviceResult);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getMeditationCount(Request $request)
    {
        // TODO: User' ın tamamladığı meditasyon sayısı
        $serviceResult = StatisticService::getMeditationCount($request);

        return $this->responseJson($serviceResult);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getMeditationTotalTime(Request $request)
    {
        // TODO: User' ın tamamladığı meditasyonların toplam süresi
        $serviceResult = StatisticService::getMeditationTotalTime($request);

        return $this->responseJson($serviceResult);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getMeditationTopCount(Request $request)
    {
        // TODO: User' ın ara vermeden maksimum kaç gün meditasyon yaptığı sayısı
        $serviceResult = StatisticService::getMeditationTopCount($request);

        return $this->responseJson($serviceResult);
    }
}
