<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        
    }

    public function viewAny(User $user): bool{
        return $user->is_admin;
    }

    public function view(User $user): bool{
        return $user->is_admin;
    }

    public function update(User $user, User $userToUpdate): bool{
        return $user->is_admin;
    }

    public function delete(User $user, User $userToDelete): bool{
        if ($user->is_admin) return true;

        if ($user->id === $userToDelete->id){
            return true;
        }

        return false;
    }
}
