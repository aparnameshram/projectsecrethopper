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
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser, User $user): bool
    {
        return ($authUser->isAdministrator() || $authUser->id === $user->id);
    }

    /**
     * only admin can delete user
     */
    public function delete(User $authUser, User $user): bool
    {
        return ($authUser->isAdministrator());
    }

    /**
     * only admin can see all user
     */
    public function viewAny(User $user): bool
    {

        return ($user->isAdministrator());
    }

    public function view(User $authUser, User $user): bool
    {
        return ($authUser->isAdministrator() || $authUser->id === $user->id);
    }
}
