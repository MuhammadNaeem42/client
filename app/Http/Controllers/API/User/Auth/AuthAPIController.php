<?php

namespace App\Http\Controllers\API\User\Auth;


use App\Http\Controllers\AppBaseController;
use App\Http\Requests\User\LoginUserAPIRequest;
use App\Http\Resources\User\UserResource;


class AuthAPIController extends AppBaseController
{


    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login']]);
    }


    public function login(LoginUserAPIRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!auth('user-api')->attempt($credentials)) {
            return $this->makeError(trans('lang.api.unauthorized'));
        }

        $user = auth('user-api')->user();

        //check user is IsActive
        if (!$user->is_active) {
            return $this->makeError(trans('lang.api.user_block'));
        }
        $token = $user->createToken('userToken')->plainTextToken;

        return $this->sendResponse($this->createNewToken($token, $user), 'Token Created.');


    }

    protected function createNewToken($token, $user)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('sanctum.expiration'),
            'user' => new UserResource($user)
        ];

    }

    public function logout()
    {

        request()->user()->tokens()->delete();
        return $this->sendSuccess(trans('lang.api.user_logout'));

    }


}
