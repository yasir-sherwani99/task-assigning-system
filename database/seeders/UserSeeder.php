<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = array(
            array(
                'first_name' => 'Yasir',
                'last_name' => 'Naeem',
                'email' => 'yasir.sherwani@gmail.com',
                'password' => Hash::make('123456'),
                'photo' => null,
                'phone' => null,
                'address' => null,
                'city' => 'Lahore',
                'country' => 'Pakistan',
                'status' => 'active'
            ),
            array(
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'photo' => null,
                'phone' => null,
                'address' => null,
                'city' => 'Lahore',
                'country' => 'Pakistan',
                'status' => 'active'
            ),
        );

        if(count($admins) > 0) {
            foreach($admins as $admin) {
                User::updateOrCreate([
                    'email' => $admin['email']
                ],[
                    'first_name' => $admin['first_name'],
                    'last_name' => $admin['last_name'],
                    'password' => $admin['password'],
                    'photo' => $admin['photo'],
                    'phone' => $admin['phone'],
                    'address' => $admin['address'],
                    'city' => $admin['city'],
                    'country' => $admin['country'],
                    'status' => $admin['status']
                ]);
            }
        }
    }
}
