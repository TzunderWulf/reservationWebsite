<?php

// creates an array for the timecolumn in the admin overview  (see admin/index.php)
function timesArray (string $start, string $end, int $interval) {
    $times = [];
    $time = strtotime($start);
    $timeToAdd = 30;

    while ($time <= strtotime($end)) {
        $times[] = date('H:i', $time);
        $time +=  60 * $timeToAdd;
    }
    return $times;
}