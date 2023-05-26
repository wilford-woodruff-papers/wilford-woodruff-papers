<?php

namespace App\Policies;

use App\Models\EventRegistration;
use App\Models\User;

class EventRegistrationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EventRegistration $eventRegistration): bool
    {
        return $user->hasAnyRole(['Admin', 'Super Admin']);
    }
}
