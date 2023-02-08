<?php

use App\Team;
use Carbon\Carbon;

function getTeamName()
{
    $teamId = auth()->user()->team_id;
    return  Team::where('id', $teamId)->select('name')->first()->name ?? ' ';
}

