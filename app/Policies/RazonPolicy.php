<?php

namespace App\Policies;

use App\Models\Razon;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RazonPolicy
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
        if($user->permissions->contains('slug','razon-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Razon  $razon
     * @return mixed
     */
    public function view(User $user, Razon $razon)
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
        if($user->permissions->contains('slug','razon-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Razon  $razon
     * @return mixed
     */
    public function update(User $user, Razon $razon)
    {
        if($user->permissions->contains('slug','razon-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Razon  $razon
     * @return mixed
     */
    public function delete(User $user, Razon $razon)
    {
        if($user->permissions->contains('slug','razon-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Razon  $razon
     * @return mixed
     */
    public function restore(User $user, Razon $razon)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Razon  $razon
     * @return mixed
     */
    public function forceDelete(User $user, Razon $razon)
    {
        //
    }
}
