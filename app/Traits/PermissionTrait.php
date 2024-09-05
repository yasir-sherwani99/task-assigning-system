<?php

namespace App\Traits;

use App\Models\Group;
use App\Models\Permission;

trait PermissionTrait
{
    public function getAllPermissionsWithGroups()
    {
        $permissionArray = [];
        $groups = Group::all();
    
        foreach($groups as $key => $value) {
            $data = [];
            $getPermissionGroup = Permission::where('group_id', $value->id)->get();
            $data['id'] = $value->id;
            $data['name'] = $value->name;

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
