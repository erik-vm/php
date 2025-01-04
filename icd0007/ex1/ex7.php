<?php

function getDaysUnderTemp(int $targetYear, float $targetTemp): float
{
    $inputFile = fopen(__DIR__ . "/data/temperatures-filtered.csv", "r");
    $totalHours = 0;
    while (!feof($inputFile)) {
        $dict = fgetcsv($inputFile);
        if ($dict) {
            $year = $dict[0];
            $temp = $dict[4];
            if ($year == $targetYear && $temp <= $targetTemp) {
                $totalHours++;
            }
        }
    }
    fclose($inputFile);
    return abs(round(($totalHours / 24), 2));
}


//var_dump(getDaysUnderTemp(2021, -10));