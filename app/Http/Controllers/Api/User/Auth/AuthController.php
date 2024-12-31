<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Services\Api\User\Auth\UserAuthService;
use App\Http\Requests\Api\User\Auth\LoginRequest;
use App\Http\Requests\Api\User\Auth\RegisterRequest;


class AuthController extends Controller
{
    public function __construct(private UserAuthService $userAuthService) {}

    public function register(RegisterRequest $request)
    {
        return $this->userAuthService->userRegister($request);
    }

    public function login(LoginRequest $request)
    {
        return $this->userAuthService->login($request);
    }


    public function logout()
    {
        return $this->userAuthService->userLogout();
    }

}
