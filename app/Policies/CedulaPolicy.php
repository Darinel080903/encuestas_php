<?php

namespace App\Policies;

use App\Models\Cedula;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CedulaPolicy
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
        if($user->permissions->contains('slug','cedula-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cedula  $cedula
     * @return mixed
     */
    public function view(User $user, Cedula $cedula)
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
        if($user->permissions->contains('slug','cedula-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cedula  $cedula
     * @return mixed
     */
    public function update(User $user, Cedula $cedula)
    {
        if($user->permissions->contains('slug','cedula-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cedula  $cedula
     * @return mixed
     */
    public function delete(User $user, Cedula $cedula)
    {
        if($user->permissions->contains('slug','cedula-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cedula  $cedula
     * @return mixed
     */
    public function restore(User $user, Cedula $cedula)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cedula  $cedula
     * @return mixed
     */
    public function forceDelete(User $user, Cedula $cedula)
    {
        //
    }
}
