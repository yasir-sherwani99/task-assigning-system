<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = array(
            array(
                'id' => 1,
                'name' => 'Dashboard'
            ),
            array(
                'id' => 2,
                'name' => 'Client'
            ),
            array(
                'id' => 3,
                'name' => 'Project'
            ),
            array(
                'id' => 4,
                'name' => 'Task'
            ),
            array(
                'id' => 5,
                'name' => 'Defect'
            ),
            array(
                'id' => 6,
                'name' => 'Meeting'
            ),
            array(
                'id' => 7,
                'name' => 'Appointment'
            ),
            array(
                'id' => 8,
                'name' => 'Reports'
            ),
            array(
                'id' => 9,
                'name' => 'User'
            ),
            array(
                'id' => 10,
                'name' => 'Team'
            ),
            array(
                'id' => 11,
                'name' => 'Role'
            ),
            array(
                'id' => 12,
                'name' => 'Permission'
            ),
            array(
                'id' => 13,
                'name' => 'Todo'
            ),
            array(
                'id' => 14,
                'name' => 'Settings'
            ),
        );

        if(count($groups) > 0) {
            foreach($groups as $group) {
                Group::updateOrCreate([
                    'name' => $group['name']
                ],[
                    'id' => $group['id']
                ]);
            }
        }
    }
}
