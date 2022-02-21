<?php

namespace App\Policies;

use App\Models\User;
use App\Models\partida;
use Illuminate\Auth\Access\HandlesAuthorization;

class PartidaPolicy
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
        if($user->permissions->contains('slug','partida-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\partida  $partida
     * @return mixed
     */
    public function view(User $user, partida $partida)
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
        if($user->permissions->contains('slug','partida-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\partida  $partida
     * @return mixed
     */
    public function update(User $user, partida $partida)
    {
        if($user->permissions->contains('slug','partida-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\partida  $partida
     * @return mixed
     */
    public function delete(User $user, partida $partida)
    {
        if($user->permissions->contains('slug','partida-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\partida  $partida
     * @return mixed
     */
    public function restore(User $user, partida $partida)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\partida  $partida
     * @return mixed
     */
    public function forceDelete(User $user, partida $partida)
    {
        //
    }
}
