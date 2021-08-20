<?php

namespace App\Policies;

use App\Models\Marca;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MarcaPolicy
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
        if($user->permissions->contains('slug','marca-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Marca  $marca
     * @return mixed
     */
    public function view(User $user, Marca $marca)
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
        if($user->permissions->contains('slug','marca-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Marca  $marca
     * @return mixed
     */
    public function update(User $user, Marca $marca)
    {
        if($user->permissions->contains('slug','marca-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Marca  $marca
     * @return mixed
     */
    public function delete(User $user, Marca $marca)
    {
        if($user->permissions->contains('slug','marca-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Marca  $marca
     * @return mixed
     */
    public function restore(User $user, Marca $marca)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Marca  $marca
     * @return mixed
     */
    public function forceDelete(User $user, Marca $marca)
    {
        //
    }
}
