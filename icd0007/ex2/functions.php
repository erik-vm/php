<?php

function getAverageWinterTemp(int $winterStartYear, int $winterEndYear): float
{
    $inputFile = fopen(__DIR__ . "/../ex1/data/temperatures-filtered.csv", "r");
    $totalHours = 0;
    $totalTemp = 0;
    while (!feof($inputFile)) {
        $dict = fgetcsv($inputFile);
        if ($dict) {
            $year = intval($dict[0]);
            $month = intval($dict[1]);
            $temp = floatval($dict[4]);
            if (($year === $winterStartYear && $month === 12) || ($year === $winterEndYear && ($month === 1 || $month === 2))) {
                $totalHours++;
                $totalTemp += $temp;
            }
        }
    }
    fclose($inputFile);
    return round(($totalTemp / $totalHours), 2);
}
