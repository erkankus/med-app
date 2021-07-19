<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Results\ServiceResult;

class AuthService
{
    /**
     * @param Request $request
     * @return ServiceResult
     */
    public static function login(Request $request): ServiceResult
    {
        $serviceResult = new ServiceResult();

        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $serviceResult->setSuccess(false);
            $serviceResult->setMessage($validator->errors()->first());
            return $serviceResult;
        }

        // User Auth Control
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $serviceResult->setSuccess(false);
            $serviceResult->setMessage(__('login.user_not_found'));
            return $serviceResult;
        }

        $token = $user->createToken('user-api-token')->plainTextToken;

        $data = [
            'user' => $user,
            'token' => $token
        ];

        $serviceResult->setSuccess(true);
        $serviceResult->setData($data);

        return $serviceResult;
    }
}
