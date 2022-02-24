<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vsolicitud;
use Illuminate\Auth\Access\HandlesAuthorization;

class VsolicitudPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if($user->isAdmin())
        {
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
        if($user->permissions->contains('slug','solicitud-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vsolicitud  $vsolicitud
     * @return mixed
     */
    public function view(User $user, Vsolicitud $vsolicitud)
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
        if($user->permissions->contains('slug','solicitud-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vsolicitud  $vsolicitud
     * @return mixed
     */
    public function update(User $user, Vsolicitud $vsolicitud)
    {
        if($user->permissions->contains('slug','solicitud-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vsolicitud  $vsolicitud
     * @return mixed
     */
    public function delete(User $user, Vsolicitud $vsolicitud)
    {
        if($user->permissions->contains('slug','solicitud-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vsolicitud  $vsolicitud
     * @return mixed
     */
    public function restore(User $user, Vsolicitud $vsolicitud)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vsolicitud  $vsolicitud
     * @return mixed
     */
    public function forceDelete(User $user, Vsolicitud $vsolicitud)
    {
        //
    }
}
