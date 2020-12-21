<?php
function createArrayWithTimes(string $start, string $end, int $interval) {
    $times = [];

    $time = strtotime($start);
    $timeToAdd = 30;

    // loop (while of for loop)
    while($time <= strtotime($end))
    {
        // time toevoegen aan times array
        $times[] = date('H:i', $time);

        // time + een half uur optellen
        $time +=  60 * $timeToAdd;
    }

    return $times;
}