<?php

use App\Team;
use App\User;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams =[
         ['name' => 'wearthree'],   
         ['name' => 'fation virus'],
         ['name' => 'a to z'],
         ['name' => 'sundaram tailor'],
        ];
        foreach ($teams as $team) {
        Team::Create($team);
        }
    }
}
