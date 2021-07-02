<?php

namespace App\Policies;

use App\Models\Fabrica;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FabricaPolicy
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
        if($user->permissions->contains('slug','fabrica-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fabrica  $fabrica
     * @return mixed
     */
    public function view(User $user, Fabrica $fabrica)
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
        if($user->permissions->contains('slug','fabrica-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fabrica  $fabrica
     * @return mixed
     */
    public function update(User $user, Fabrica $fabrica)
    {
        if($user->permissions->contains('slug','fabrica-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fabrica  $fabrica
     * @return mixed
     */
    public function delete(User $user, Fabrica $fabrica)
    {
        if($user->permissions->contains('slug','fabrica-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fabrica  $fabrica
     * @return mixed
     */
    public function restore(User $user, Fabrica $fabrica)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Fabrica  $fabrica
     * @return mixed
     */
    public function forceDelete(User $user, Fabrica $fabrica)
    {
        //
    }
}
