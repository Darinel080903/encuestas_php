<?php

namespace App\Policies;

use App\Models\Combustible;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CombustiblePolicy
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
        if($user->permissions->contains('slug','combustible-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Combustible  $combustible
     * @return mixed
     */
    public function view(User $user, Combustible $combustible)
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
        if($user->permissions->contains('slug','combustible-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Combustible  $combustible
     * @return mixed
     */
    public function update(User $user, Combustible $combustible)
    {
        if($user->permissions->contains('slug','combustible-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Combustible  $combustible
     * @return mixed
     */
    public function delete(User $user, Combustible $combustible)
    {
        if($user->permissions->contains('slug','combustible-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Combustible  $combustible
     * @return mixed
     */
    public function restore(User $user, Combustible $combustible)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Combustible  $combustible
     * @return mixed
     */
    public function forceDelete(User $user, Combustible $combustible)
    {
        //
    }
}
