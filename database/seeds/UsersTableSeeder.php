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
                'email'          => 'admin@admin.com',
                'segment_id'     => '1',
                'team_id'        => 1,
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'fashiton virus',
                'email'          => 'fashtionvirus@admin.com',
                'password'       => '$2y$10$KjopsXqbCq1NrrGYJe7rr./68LzZSGCas5XxBHHbG.9AF4mc3GPR.',
                'email'          => 'fashtionvirus@admin.com',
                'segment_id'     => '1',
                'team_id'        => 2,
                'remember_token' => null,
            ],
            [
                'id'             => 3,
                'name'           => 'a to z',
                'email'          => 'atoz@admin.com',
                'password'       => '$2y$10$KjopsXqbCq1NrrGYJe7rr./68LzZSGCas5XxBHHbG.9AF4mc3GPR.',
                'email'          => 'atoz@admin.com',
                'segment_id'     => '1',
                'team_id'        => 3,
                'remember_token' => null,
            ],
            [
                'id'             => 4,
                'name'           => 'sundaram tailor',
                'email'          => 'sundaramtailor@admin.com',
                'password'       => '$2y$10$KjopsXqbCq1NrrGYJe7rr./68LzZSGCas5XxBHHbG.9AF4mc3GPR.',
                'email'          => 'sundaramtailor@admin.com',
                'segment_id'     => '2',
                'team_id'        => 4,
                'remember_token' => null,
            ],
        ];
        //   $roles = ['admin','user','user','user'];

        foreach ($users as $key => $user) {
            $user = User::create($user);
            // $user->assignRole($roles[$key]);
        }
    }
}
