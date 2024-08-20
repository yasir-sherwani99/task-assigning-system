<?php

namespace App\Traits;

use App\Models\Permission;

trait PermissionTrait
{
    public function getAllPermissionsWithGroups()
    {
        $permissionArray = [];
        $permissions = Permission::with('groups')->groupBy('group_id')->get();
    
        foreach($permissions as $key => $value) {
            $data = [];
            $getPermissionGroup = Permission::where('group_id', $value->group_id)->get();
            $data['id'] = $value->id;
            $data['name'] = $value->groups->name;

            $group = [];
            foreach($getPermissionGroup as $valueG) {
                $dataG = [];
                $dataG['id'] = $valueG->id;
                $dataG['name'] = $valueG->name;
                $group[] = $dataG;
            }

            $data['group'] = $group;
            $permissionArray[] = $data;
        }

        return $permissionArray;
    }
}
