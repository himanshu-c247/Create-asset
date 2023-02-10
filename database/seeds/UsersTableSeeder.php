<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$KjopsXqbCq1NrrGYJe7rr./68LzZSGCas5XxBHHbG.9AF4mc3GPR.',
                'segment_id'     => '2',
                'team_id'        => 1,
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'Store Manger',
                'email'          => 'storemanger@admin.com',
                'password'       => '$2y$10$KjopsXqbCq1NrrGYJe7rr./68LzZSGCas5XxBHHbG.9AF4mc3GPR.',
                'segment_id'     => '2',
                'team_id'        => 2,
                'remember_token' => null,
            ],
            [
                'id'             => 3,
                'name'           => 'Retailer',
                'email'          => 'retailer@admin.com',
                'password'       => '$2y$10$KjopsXqbCq1NrrGYJe7rr./68LzZSGCas5XxBHHbG.9AF4mc3GPR.',
                'segment_id'     => '2',
                'team_id'        => 3,
                'remember_token' => null,
            ],
            [
                'id'             => 4,
                'name'           => 'Exhibitor',
                'email'          => 'exhibitor@admin.com',
                'password'       => '$2y$10$KjopsXqbCq1NrrGYJe7rr./68LzZSGCas5XxBHHbG.9AF4mc3GPR.',
                'segment_id'     => '1',
                'team_id'        => 4,
                'remember_token' => null,
            ],
        ];
        foreach ($users as $key => $user) {
            $user = User::create($user);
            // $user->assignRole($roles[$key]);
        }
    }
}
