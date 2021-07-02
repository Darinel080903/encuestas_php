<?php

namespace App\Policies;

use App\Models\Articulo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticuloPolicy
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
        if($user->permissions->contains('slug','articulo-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulo  $articulo
     * @return mixed
     */
    public function view(User $user, Articulo $articulo)
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
        if($user->permissions->contains('slug','articulo-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulo  $articulo
     * @return mixed
     */
    public function update(User $user, Articulo $articulo)
    {
        if($user->permissions->contains('slug','articulo-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulo  $articulo
     * @return mixed
     */
    public function delete(User $user, Articulo $articulo)
    {
        if($user->permissions->contains('slug','articulo-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulo  $articulo
     * @return mixed
     */
    public function restore(User $user, Articulo $articulo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Articulo  $articulo
     * @return mixed
     */
    public function forceDelete(User $user, Articulo $articulo)
    {
        //
    }
}
