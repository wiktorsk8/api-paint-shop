<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\User\AuthService;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ){}
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register(
            $request->name,
            $request->email,
            $request->password);

        return response()->json($result, 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        return $this->authService->login($credentials);
    }

    public function logout(): JsonResponse
    {
        return $this->authService->logout();
    }

    public function checkAuth(): JsonResponse{
         /** @var User $user */
        return response()->json(['isUserAuth' => Auth::guard('api')->check()], 200);
    }
}
