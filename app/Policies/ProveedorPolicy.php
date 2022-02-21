<?php

namespace App\Policies;

use App\Models\User;
use App\Models\proveedor;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProveedorPolicy
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
        if($user->permissions->contains('slug','proveedor-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\proveedor  $proveedor
     * @return mixed
     */
    public function view(User $user, proveedor $proveedor)
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
        if($user->permissions->contains('slug','proveedor-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\proveedor  $proveedor
     * @return mixed
     */
    public function update(User $user, proveedor $proveedor)
    {
        if($user->permissions->contains('slug','proveedor-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\proveedor  $proveedor
     * @return mixed
     */
    public function delete(User $user, proveedor $proveedor)
    {
        if($user->permissions->contains('slug','proveedor-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\proveedor  $proveedor
     * @return mixed
     */
    public function restore(User $user, proveedor $proveedor)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\proveedor  $proveedor
     * @return mixed
     */
    public function forceDelete(User $user, proveedor $proveedor)
    {
        //
    }
}
