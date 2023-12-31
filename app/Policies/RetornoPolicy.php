<?php

namespace App\Policies;

use App\Models\Retorno;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RetornoPolicy
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
        if($user->permissions->contains('slug','retorno-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Retorno  $retorno
     * @return mixed
     */
    public function view(User $user, Retorno $retorno)
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
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Retorno  $retorno
     * @return mixed
     */
    public function update(User $user, Retorno $retorno)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Retorno  $retorno
     * @return mixed
     */
    public function delete(User $user, Retorno $retorno)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Retorno  $retorno
     * @return mixed
     */
    public function restore(User $user, Retorno $retorno)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Retorno  $retorno
     * @return mixed
     */
    public function forceDelete(User $user, Retorno $retorno)
    {
        //
    }
}
