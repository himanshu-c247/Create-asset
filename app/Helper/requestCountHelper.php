<?php

use App\StockRequest;

function stockRequestCount()
{
    $data = StockRequest::where('status', '0')->count();
    return $data;
}
