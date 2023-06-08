<?php

namespace App\Policies;

use App\Models\ContentPage;
use App\Models\User;

class ContentPagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContentPage $contentPage): bool
    {
        return $user->hasAnyRole(['Admin']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['Admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContentPage $contentPage): bool
    {
        return $user->hasAnyRole(['Admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContentPage $contentPage): bool
    {
        return $user->hasAnyRole(['Admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContentPage $contentPage): bool
    {
        return $user->hasAnyRole(['Admin']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContentPage $contentPage): bool
    {
        return $user->hasAnyRole(['Admin']);
    }
}
