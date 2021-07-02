<?php

namespace App\Policies;

use App\Models\Funcionario;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FuncionarioPolicy
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
        if($user->permissions->contains('slug','funcionario-lista'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Funcionario  $funcionario
     * @return mixed
     */
    public function view(User $user, Funcionario $funcionario)
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
        if($user->permissions->contains('slug','funcionario-crear'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Funcionario  $funcionario
     * @return mixed
     */
    public function update(User $user, Funcionario $funcionario)
    {
        if($user->permissions->contains('slug','funcionario-editar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Funcionario  $funcionario
     * @return mixed
     */
    public function delete(User $user, Funcionario $funcionario)
    {
        if($user->permissions->contains('slug','funcionario-eliminar'))
        {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Funcionario  $funcionario
     * @return mixed
     */
    public function restore(User $user, Funcionario $funcionario)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Funcionario  $funcionario
     * @return mixed
     */
    public function forceDelete(User $user, Funcionario $funcionario)
    {
        //
    }
}
