<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ApiUserLoginRequest;
use App\Http\Requests\ApiUserRegisterRequest;
use Illuminate\Support\Facades\Auth;

class ApiUserController extends Controller
{
    /**
     * @param  UserService $userService
     * @param  ApiUserRegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserService $userService, ApiUserRegisterRequest $request): JsonResponse
    {
        $params = $request->validated();

        return response()->json($userService->register($params));
    }

    /**
     * @param  UserService $userService
     * @param  ApiUserLoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserService $userService, ApiUserLoginRequest $request): JsonResponse
    {
        $attempt = Auth::guard()->attempt(
            $request->only('email', 'password'),
            $request->filled('remember')
        );

        if (!$attempt) {
            $response = ['success' => false];
        } else {
            $response = $userService->login($request->validated());
        }

        return response()->json($response);
    }
}
