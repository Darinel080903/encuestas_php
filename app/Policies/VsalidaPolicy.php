<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vsalida;
use Illuminate\Auth\Access\HandlesAuthorization;

class VsalidaPolicy
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
        if($user->permissions->contains('slug','salida-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vsalida  $vsalida
     * @return mixed
     */
    public function view(User $user, Vsalida $vsalida)
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
        if($user->permissions->contains('slug','salida-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vsalida  $vsalida
     * @return mixed
     */
    public function update(User $user, Vsalida $vsalida)
    {
        if($user->permissions->contains('slug','salida-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vsalida  $vsalida
     * @return mixed
     */
    public function delete(User $user, Vsalida $vsalida)
    {
        if($user->permissions->contains('slug','salida-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vsalida  $vsalida
     * @return mixed
     */
    public function restore(User $user, Vsalida $vsalida)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vsalida  $vsalida
     * @return mixed
     */
    public function forceDelete(User $user, Vsalida $vsalida)
    {
        //
    }
}
