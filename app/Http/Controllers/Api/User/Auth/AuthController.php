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

        $address = Address::create([
            'data' => $request->data,
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => false,
            'address_id' => $address->id

        ]);

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
