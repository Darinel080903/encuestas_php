<?php

namespace App\Policies;

use App\Models\Operativo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OperativoPolicy
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
        if($user->permissions->contains('slug','operativo-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Operativo  $operativo
     * @return mixed
     */
    public function view(User $user, Operativo $operativo)
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
        if($user->permissions->contains('slug','operativo-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Operativo  $operativo
     * @return mixed
     */
    public function update(User $user, Operativo $operativo)
    {
        if($user->permissions->contains('slug','operativo-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Operativo  $operativo
     * @return mixed
     */
    public function delete(User $user, Operativo $operativo)
    {
        if($user->permissions->contains('slug','operativo-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Operativo  $operativo
     * @return mixed
     */
    public function restore(User $user, Operativo $operativo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Operativo  $operativo
     * @return mixed
     */
    public function forceDelete(User $user, Operativo $operativo)
    {
        //
    }
}
