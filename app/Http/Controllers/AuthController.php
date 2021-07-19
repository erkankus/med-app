<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function postLogin(Request $request)
    {
        $serviceResult = AuthService::login($request);

        return $this->responseJson($serviceResult);
    }
}
