<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vvale;
use Illuminate\Auth\Access\HandlesAuthorization;

class VvalePolicy
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
        if($user->permissions->contains('slug','vale-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vvale  $vvale
     * @return mixed
     */
    public function view(User $user, Vvale $vvale)
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
        if($user->permissions->contains('slug','vale-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vvale  $vvale
     * @return mixed
     */
    public function update(User $user, Vvale $vvale)
    {
        if($user->permissions->contains('slug','vale-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vvale  $vvale
     * @return mixed
     */
    public function delete(User $user, Vvale $vvale)
    {
        if($user->permissions->contains('slug','vale-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vvale  $vvale
     * @return mixed
     */
    public function restore(User $user, Vvale $vvale)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vvale  $vvale
     * @return mixed
     */
    public function forceDelete(User $user, Vvale $vvale)
    {
        //
    }
}
