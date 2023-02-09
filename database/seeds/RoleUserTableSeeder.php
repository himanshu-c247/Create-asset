<?php

use App\User;
use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        // $roles = ['1','2','3','4'];
        $user = User::where('id', '!=',1)->get();
        User::findOrFail(1)->roles()->sync(1);
        foreach ($user as $key => $user){
            User::findOrFail($user['id'])->roles()->sync(2);
        }
    }
}
