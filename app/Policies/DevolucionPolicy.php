<?php

namespace App\Policies;

use App\Models\Devolucion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevolucionPolicy
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
        if($user->permissions->contains('slug','devolucion-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Devolucion  $devolucion
     * @return mixed
     */
    public function view(User $user, Devolucion $devolucion)
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
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Devolucion  $devolucion
     * @return mixed
     */
    public function update(User $user, Devolucion $devolucion)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Devolucion  $devolucion
     * @return mixed
     */
    public function delete(User $user, Devolucion $devolucion)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Devolucion  $devolucion
     * @return mixed
     */
    public function restore(User $user, Devolucion $devolucion)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Devolucion  $devolucion
     * @return mixed
     */
    public function forceDelete(User $user, Devolucion $devolucion)
    {
        //
    }
}
