<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Admin',
            ],
            [
                'id'    => 2,
                'title' => 'Store Manager',
            ],
            [
                'id'    => 3,
                'title' => 'Retailers',
            ],
            [
                'id'    => 4,
                'title' => 'Exhibitor',
            ],
        ];

        Role::insert($roles);

    }
}
