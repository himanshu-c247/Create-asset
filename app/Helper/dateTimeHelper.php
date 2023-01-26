<?php

use Carbon\Carbon;

function dateFormat($date)
{
    if($date) {

        return Carbon::parse($date)->format('m/d/Y h:i');
    } 

    return 'NA';
}

