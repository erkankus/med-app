<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function postLogin(Request $request)
    {
        $serviceResult = UserService::login($request);
        return $this->responseJson($serviceResult);
    }
}
