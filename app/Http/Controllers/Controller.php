<?php

namespace App\Http\Controllers;

use App\Results\ServiceResult;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param ServiceResult $serviceResult
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseJson(ServiceResult $serviceResult)
    {
        return response()->json([
            'success' => $serviceResult->isSuccess(),
            'message' => $serviceResult->getMessage(),
            'data' => [
                $serviceResult->getData()
            ]
        ]);
    }
}
