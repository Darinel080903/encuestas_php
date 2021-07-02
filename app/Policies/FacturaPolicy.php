<?php

namespace App\Policies;

use App\Models\Factura;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FacturaPolicy
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
        if($user->permissions->contains('slug','factura-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Factura  $factura
     * @return mixed
     */
    public function view(User $user, Factura $factura)
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
        if($user->permissions->contains('slug','factura-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Factura  $factura
     * @return mixed
     */
    public function update(User $user, Factura $factura)
    {
        if($user->permissions->contains('slug','factura-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Factura  $factura
     * @return mixed
     */
    public function delete(User $user, Factura $factura)
    {
        if($user->permissions->contains('slug','factura-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Factura  $factura
     * @return mixed
     */
    public function restore(User $user, Factura $factura)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Factura  $factura
     * @return mixed
     */
    public function forceDelete(User $user, Factura $factura)
    {
        //
    }
}
