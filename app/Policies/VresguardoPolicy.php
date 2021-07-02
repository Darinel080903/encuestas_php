<?php

namespace App\Policies;


use App\Models\Vresguardo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VresguardoPolicy
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
        if($user->permissions->contains('slug','resguardo-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vresguardo  $vresguardo
     * @return mixed
     */
    public function view(User $user, Vresguardo $vresguardo)
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
     * @param  \App\Models\Vresguardo  $vresguardo
     * @return mixed
     */
    public function update(User $user, Vresguardo $vresguardo)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vresguardo  $vresguardo
     * @return mixed
     */
    public function delete(User $user, Vresguardo $vresguardo)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vresguardo  $vresguardo
     * @return mixed
     */
    public function restore(User $user, Vresguardo $vresguardo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vresguardo  $vresguardo
     * @return mixed
     */
    public function forceDelete(User $user, Vresguardo $vresguardo)
    {
        //
    }
}
