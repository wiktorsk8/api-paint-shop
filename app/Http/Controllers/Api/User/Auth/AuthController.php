<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(RegisterRequest $request){

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('user');

        $token = $user->createToken('auth-token')->plainTextToken;

        return response(compact('token','user'));
    }

    public function login(LoginRequest $request){

        $credentials = $request->validated();
        if (auth()->attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(){

        $user = Auth::user();
        if ($user){
            $user->currentAccessToken()->delete();
        }

        return response('logged out!');
    }
}
