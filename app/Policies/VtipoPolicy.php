<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vtipo;
use Illuminate\Auth\Access\HandlesAuthorization;

class VtipoPolicy
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
        if($user->permissions->contains('slug','tipo-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vtipo  $vtipo
     * @return mixed
     */
    public function view(User $user, Vtipo $vtipo)
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
        if($user->permissions->contains('slug','tipo-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vtipo  $vtipo
     * @return mixed
     */
    public function update(User $user, Vtipo $vtipo)
    {
        if($user->permissions->contains('slug','tipo-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vtipo  $vtipo
     * @return mixed
     */
    public function delete(User $user, Vtipo $vtipo)
    {
        if($user->permissions->contains('slug','tipo-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vtipo  $vtipo
     * @return mixed
     */
    public function restore(User $user, Vtipo $vtipo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vtipo  $vtipo
     * @return mixed
     */
    public function forceDelete(User $user, Vtipo $vtipo)
    {
        //
    }
}
