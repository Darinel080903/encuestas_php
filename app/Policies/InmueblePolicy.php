<?php

namespace App\Policies;

use App\Models\Inmueble;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InmueblePolicy
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
        if($user->permissions->contains('slug','inmueble-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function view(User $user, Inmueble $inmueble)
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
        if($user->permissions->contains('slug','inmueble-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function update(User $user, Inmueble $inmueble)
    {
        if($user->permissions->contains('slug','inmueble-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function delete(User $user, Inmueble $inmueble)
    {
        if($user->permissions->contains('slug','inmueble-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function restore(User $user, Inmueble $inmueble)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Inmueble  $inmueble
     * @return mixed
     */
    public function forceDelete(User $user, Inmueble $inmueble)
    {
        //
    }
}
