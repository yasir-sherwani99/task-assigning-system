<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = array(
            array(
                'name' => 'View Roles',
                'group_id' => 11,
            ),
            array(
                'name' => 'Edit Role',
                'group_id' => 11,
            ),
            array(
                'name' => 'View Permissions',
                'group_id' => 12,
            ),
            array(
                'name' => 'Edit Permission',
                'group_id' => 12,
            ),
            array(
                'name' => 'View Users',
                'group_id' => 9,
            ),
            array(
                'name' => 'Create User',
                'group_id' => 9,
            ),
            array(
                'name' => 'Edit User',
                'group_id' => 9,
            ),
            array(
                'name' => 'Delete User',
                'group_id' => 9,
            ),
            array(
                'name' => 'View Clients',
                'group_id' => 2,
            ),
            array(
                'name' => 'Create Client',
                'group_id' => 2,
            ),
            array(
                'name' => 'Edit Client',
                'group_id' => 2,
            ),
            array(
                'name' => 'Delete Client',
                'group_id' => 2,
            ),
            array(
                'name' => 'View Dashboard',
                'group_id' => 1,
            ),
            array(
                'name' => 'View Projects',
                'group_id' => 3,
            ),
            array(
                'name' => 'Create Project',
                'group_id' => 3,
            ),
            array(
                'name' => 'Edit Project',
                'group_id' => 3,
            ),
            array(
                'name' => 'Show Project',
                'group_id' => 3,
            ),
            array(
                'name' => 'Delete Project',
                'group_id' => 3,
            ),
            array(
                'name' => 'View Tasks',
                'group_id' => 4,
            ),
            array(
                'name' => 'Create Task',
                'group_id' => 4,
            ),
            array(
                'name' => 'Edit Task',
                'group_id' => 4,
            ),
            array(
                'name' => 'Show Task',
                'group_id' => 4,
            ),
            array(
                'name' => 'Delete Task',
                'group_id' => 4,
            ),
            array(
                'name' => 'View Defects',
                'group_id' => 5,
            ),
            array(
                'name' => 'Create Defect',
                'group_id' => 5,
            ),
            array(
                'name' => 'Edit Defect',
                'group_id' => 5,
            ),
            array(
                'name' => 'Show Defect',
                'group_id' => 5,
            ),
            array(
                'name' => 'Delete Defect',
                'group_id' => 5,
            ),
            array(
                'name' => 'View Meetings',
                'group_id' => 6,
            ),
            array(
                'name' => 'Create Meeting',
                'group_id' => 6,
            ),
            array(
                'name' => 'Edit Meeting',
                'group_id' => 6,
            ),
            array(
                'name' => 'Delete Meeting',
                'group_id' => 6,
            ),
            array(
                'name' => 'View Appointments',
                'group_id' => 7,
            ),
            array(
                'name' => 'Create Appointment',
                'group_id' => 7,
            ),
            array(
                'name' => 'Edit Appointment',
                'group_id' => 7,
            ),
            array(
                'name' => 'Delete Appointment',
                'group_id' => 7,
            ),
            array(
                'name' => 'View Teams',
                'group_id' => 10,
            ),
            array(
                'name' => 'Create Team',
                'group_id' => 10,
            ),
            array(
                'name' => 'Edit Team',
                'group_id' => 10,
            ),
            array(
                'name' => 'Delete Team',
                'group_id' => 10,
            ),
            array(
                'name' => 'View Reports',
                'group_id' => 8,
            ),
            array(
                'name' => 'Download Reports',
                'group_id' => 8,
            ),
            array(
                'name' => 'View Todos',
                'group_id' => 13,
            ),
            array(
                'name' => 'Create Todo',
                'group_id' => 13,
            ),
            array(
                'name' => 'Edit Todo',
                'group_id' => 13,
            ),
            array(
                'name' => 'Show Todo',
                'group_id' => 13,
            ),
            array(
                'name' => 'Delete Todo',
                'group_id' => 13,
            ),
            array(
                'name' => 'View Settings',
                'group_id' => 14,
            ),
            array(
                'name' => 'Edit Settings',
                'group_id' => 14,
            ),
        );

        if(count($permissions) > 0) {
            foreach($permissions as $permission) {
                Permission::updateOrCreate([
                    'name' => $permission['name']
                ],[
                    'group_id' => $permission['group_id']
                ]);
            }
        }
    }
}
