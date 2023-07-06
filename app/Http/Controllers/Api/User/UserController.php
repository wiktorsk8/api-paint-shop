<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(){
        return UserResource::collection(User::all());
    }

    public function show(User $user){
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user){
        $user->update($request->validated());

        return new UserResource($user);
    }

    public function destroy(User $user){
        $id = $user->id;
        $user->delete();

        return response()->json(['message' => "User (id: {$id}) deleted succesfully"], 200);
    }
}
