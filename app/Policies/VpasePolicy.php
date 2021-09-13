<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vpase;
use Illuminate\Auth\Access\HandlesAuthorization;

class VpasePolicy
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
        if($user->permissions->contains('slug','pase-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vpase  $vpase
     * @return mixed
     */
    public function view(User $user, Vpase $vpase)
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
        if($user->permissions->contains('slug','pase-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vpase  $vpase
     * @return mixed
     */
    public function update(User $user, Vpase $vpase)
    {
        if($user->permissions->contains('slug','pase-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vpase  $vpase
     * @return mixed
     */
    public function delete(User $user, Vpase $vpase)
    {
        if($user->permissions->contains('slug','pase-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vpase  $vpase
     * @return mixed
     */
    public function restore(User $user, Vpase $vpase)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vpase  $vpase
     * @return mixed
     */
    public function forceDelete(User $user, Vpase $vpase)
    {
        //
    }
}
