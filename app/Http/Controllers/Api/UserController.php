<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\UserService;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService)
    {
        $this->authorizeResource(User::class, 'user');
    }

    // Only as admin
    public function index(){
        return UserResource::collection(User::paginate());
    }

    // Only as admin or user can view himself
    public function show(User $user){
        return new UserResource($user);
    }

    // Only as admin or user can update himself
    public function update(UpdateUserRequest $request, User $user){
        $user->update($request->validated());

        return new UserResource($user);
    }

    // Only admin
    public function destroy(User $user){
        $id = $user->id;
        $user->delete();

        return response()->json(['message' => "User (id: {$id}) deleted succesfully"], 200);
    }
}
