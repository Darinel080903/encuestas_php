<?php

namespace App\Policies;

use App\Models\Pemexfactura;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PemexfacturaPolicy
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
        if($user->permissions->contains('slug', 'pemexfactura-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pemexfactura  $pemexfactura
     * @return mixed
     */
    public function view(User $user, Pemexfactura $pemexfactura)
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
        if($user->permissions->contains('slug', 'pemexfactura-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pemexfactura  $pemexfactura
     * @return mixed
     */
    public function update(User $user, Pemexfactura $pemexfactura)
    {
        if($user->permissions->contains('slug', 'pemexfactura-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pemexfactura  $pemexfactura
     * @return mixed
     */
    public function delete(User $user, Pemexfactura $pemexfactura)
    {
        if($user->permissions->contains('slug','pemexfactura-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pemexfactura  $pemexfactura
     * @return mixed
     */
    public function restore(User $user, Pemexfactura $pemexfactura)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Pemexfactura  $pemexfactura
     * @return mixed
     */
    public function forceDelete(User $user, Pemexfactura $pemexfactura)
    {
        //
    }
}
