<?php

namespace App\Policies;

use App\Models\Reportevale;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportevalePolicy
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
        if($user->permissions->contains('slug','reporte-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reportevale  $reportevale
     * @return mixed
     */
    public function view(User $user, Reportevale $reportevale)
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
     * @param  \App\Models\Reportevale  $reportevale
     * @return mixed
     */
    public function update(User $user, Reportevale $reportevale)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reportevale  $reportevale
     * @return mixed
     */
    public function delete(User $user, Reportevale $reportevale)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reportevale  $reportevale
     * @return mixed
     */
    public function restore(User $user, Reportevale $reportevale)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Reportevale  $reportevale
     * @return mixed
     */
    public function forceDelete(User $user, Reportevale $reportevale)
    {
        //
    }
}
