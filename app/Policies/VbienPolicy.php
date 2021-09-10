<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vbien;
use Illuminate\Auth\Access\HandlesAuthorization;

class VbienPolicy
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
        if($user->permissions->contains('slug','bien-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vbien  $vbien
     * @return mixed
     */
    public function view(User $user, Vbien $vbien)
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
        if($user->permissions->contains('slug','bien-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vbien  $vbien
     * @return mixed
     */
    public function update(User $user, Vbien $vbien)
    {
        if($user->permissions->contains('slug','bien-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vbien  $vbien
     * @return mixed
     */
    public function delete(User $user, Vbien $vbien)
    {
        if($user->permissions->contains('slug','bien-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vbien  $vbien
     * @return mixed
     */
    public function restore(User $user, Vbien $vbien)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vbien  $vbien
     * @return mixed
     */
    public function forceDelete(User $user, Vbien $vbien)
    {
        //
    }
}
