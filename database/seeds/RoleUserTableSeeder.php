<?php

use App\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        // $roles = ['1','2','3','4'];
        User::findOrFail(1)->roles()->sync(1);
        User::findOrFail(2)->roles()->sync(2);
        User::findOrFail(3)->roles()->sync(3);
        User::findOrFail(4)->roles()->sync(4);
        // foreach ($user as $key => $user){
        //     User::findOrFail($user['id'])->roles()->sync(2);
        // }
    }
}
