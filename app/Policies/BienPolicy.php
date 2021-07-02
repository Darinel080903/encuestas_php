<?php

namespace App\Policies;

use App\Models\Bien;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BienPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        if($user->permissions->contains('slug','bien-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bien  $bien
     * @return mixed
     */
    public function view(User $user, Bien $bien)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if($user->permissions->contains('slug','bien-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bien  $bien
     * @return mixed
     */
    public function update(User $user, Bien $bien)
    {
        if($user->permissions->contains('slug','bien-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bien  $bien
     * @return mixed
     */
    public function delete(User $user, Bien $bien)
    {
        if($user->permissions->contains('slug','bien-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bien  $bien
     * @return mixed
     */
    public function restore(User $user, Bien $bien)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bien  $bien
     * @return mixed
     */
    public function forceDelete(User $user, Bien $bien)
    {
        //
    }
}
