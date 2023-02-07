<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Word;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class WordPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Word $word): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Word $word): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Word $word): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Word $word): Response|bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Word $word): Response|bool
    {
        return true;
    }
}
