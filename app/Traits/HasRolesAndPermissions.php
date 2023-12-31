<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

trait HasRolesAndPermissions
{
    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions');
    }

    public function hasRole($role)
    {
        if($this->roles->contains('slug', $role))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isAdmin()
    {
        if($this->roles->contains('slug','administrador'))
        {
            return true;
        }
    }
}