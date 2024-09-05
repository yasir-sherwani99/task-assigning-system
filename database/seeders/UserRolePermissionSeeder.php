<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$adminRoles = Role::pluck('id')->toArray();
		$permissions = Permission::pluck('id')->toArray();
        $users = User::whereIn('email', ['admin@gmail.com', 'yasir.sherwani@gmail.com'])->get();
		if(count($users) > 0) {
			foreach($users as $user) {
				$member = User::find($user->id);
				if(isset($member)) {
					// asign user all role
					$member->roles()->sync($adminRoles);
					// assign user all permissions
					$member->permissions()->sync($permissions);
				}
			}
		}
    }
}
