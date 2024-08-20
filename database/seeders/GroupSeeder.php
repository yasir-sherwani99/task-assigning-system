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
                'name' => 'Dashboard'
            ),
            array(
                'name' => 'User'
            ),
            array(
                'name' => 'Role'
            ),
            array(
                'name' => 'Project'
            ),
            array(
                'name' => 'Task'
            ),
            array(
                'name' => 'Settings'
            ),
            array(
                'name' => 'Reports'
            ),
            array(
                'name' => 'Permission'
            ),
            array(
                'name' => 'Client'
            ),
            array(
                'name' => 'Defect'
            ),
        );

        if(count($groups) > 0) {
            foreach($groups as $group) {
                Group::updateOrCreate([
                    'name' => $group['name']
                ]);
            }
        }
    }
}
