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
        $roles = array(
            array(
                'name' => 'View Role'
            ),
            array(
                'name' => 'Create Role'
            ),
            array(
                'name' => 'Edit Role'
            ),
            array(
                'name' => 'Delete Role'
            ),
            array(
                'name' => 'View Permission'
            ),
            array(
                'name' => 'Create Permission'
            ),
            array(
                'name' => 'Edit Permission'
            ),
            array(
                'name' => 'Delete Permission'
            ),
            array(
                'name' => 'View Admin'
            ),
            array(
                'name' => 'Create Admin'
            ),
            array(
                'name' => 'Edit Admin'
            ),
            array(
                'name' => 'Delete Admin'
            ),
            array(
                'name' => 'View Manager'
            ),
            array(
                'name' => 'Create Manager'
            ),
            array(
                'name' => 'Edit Manager'
            ),
            array(
                'name' => 'Delete Manager'
            ),
            array(
                'name' => 'View Team Member'
            ),
            array(
                'name' => 'Create Team Member'
            ),
            array(
                'name' => 'Edit Team Member'
            ),
            array(
                'name' => 'Delete Team Member'
            ),
            array(
                'name' => 'View Dasboard'
            ),
            array(
                'name' => 'View Project'
            ),
            array(
                'name' => 'Create Project'
            ),
            array(
                'name' => 'Edit Project'
            ),
            array(
                'name' => 'Delete Project'
            ),
            array(
                'name' => 'View Task'
            ),
            array(
                'name' => 'Create Task'
            ),
            array(
                'name' => 'Edit Task'
            ),
            array(
                'name' => 'Delete Task'
            ),
        );

        if(count($roles) > 0) {
            foreach($roles as $role) {
                Permission::updateOrCreate([
                    'name' => $role['name']
                ]);
            }
        }
    }
}
