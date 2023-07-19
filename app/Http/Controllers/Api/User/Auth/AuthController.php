<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Order\Address;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(RegisterRequest $request){

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response([
            'token' => $token,
            'user' => $user
        ], 201);
    }

    public function login(LoginRequest $request){
        $credentials = $request->validated();

        if (auth()->attempt($credentials)) {
            
            /** @var User $user */
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response([
                'token' => $token,
                'user' => $user
            ], 200);
        } else {
            return response(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(){
        /** @var User $user */ 
        $user = Auth::user();
        if ($user){
            $user->currentAccessToken()->delete();
        }

        return response('logged out!');
    }

    public function checkAuth(){
         /** @var User $user */
         
        return response(['is_user_auth' => Auth::guard('api')->check()], 200);
    }
}
