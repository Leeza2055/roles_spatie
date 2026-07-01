<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the actor may update the target user.
     */
    public function update(User $actor, User $target): bool
    {
        return $actor->hasRole('super_admin')
            || ($actor->hasRole('admin') && ! $target->hasRole('super_admin'));
    }

    /**
     * Determine whether the actor may delete the target user.
     */
    public function delete(User $actor, User $target): bool
    {
        return $actor->id !== $target->id && $this->update($actor, $target);
    }
}
