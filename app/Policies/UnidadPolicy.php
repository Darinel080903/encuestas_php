<?php

namespace App\Policies;

use App\Models\User;
use App\Models\unidad;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnidadPolicy
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
        if($user->permissions->contains('slug','unidad-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\unidad  $unidad
     * @return mixed
     */
    public function view(User $user, unidad $unidad)
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
        if($user->permissions->contains('slug','unidad-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\unidad  $unidad
     * @return mixed
     */
    public function update(User $user, unidad $unidad)
    {
        if($user->permissions->contains('slug','unidad-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\unidad  $unidad
     * @return mixed
     */
    public function delete(User $user, unidad $unidad)
    {
        if($user->permissions->contains('slug','unidad-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\unidad  $unidad
     * @return mixed
     */
    public function restore(User $user, unidad $unidad)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\unidad  $unidad
     * @return mixed
     */
    public function forceDelete(User $user, unidad $unidad)
    {
        //
    }
}
