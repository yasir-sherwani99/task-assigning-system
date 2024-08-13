<?php

namespace App\Traits;

use App\Models\Permission;

trait HasPermissionTrait
{
    // get all permissions
    public function getAllPermissions($permissions)
    {
        return Permission::whereIn('slug', $permissions->slug)->get();
    }

    // check permssion
    public function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }

    public function hasRole(...$roles) 
    {   
        foreach($roles as $role) {
            if($this->roles->contains('slug', $role)) {
                return true;
            }
        }
         
        return false;
    }

    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    public function hasPermissionThroughRole($permissions)
    {
        foreach($permissions->roles as $role) {
            if($this->roles->contains($role)) {
                return true;
            }
        }        

        return false;
    }
}
