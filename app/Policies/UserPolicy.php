<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.;
     */
    public function update(User $current_user, User $target_user): bool
    {
        return $current_user->role_name === 'super_admin' || ($current_user->role_name === 'admin' && $target_user->role_name != 'super_admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $current_user, User $target_user): bool
    {
        return $current_user->id === $target_user;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
