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
         ['name' => 'Retailer'],
         ['name' => 'Exhibitor'],
        ];
        foreach ($teams as $team) {
        Team::Create($team);
        }
    }
}
