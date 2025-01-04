<?php

$inputFile = fopen("data/temperatures-sample.csv", "r");
$outputFile = fopen("temperatures-filtered.csv", "w");

while (!feof($inputFile)) {
    $dict = fgetcsv($inputFile);

    if ($dict && is_numeric($dict[0])) {
        $year = $dict[0];
        if ($year == 2004 || $year == 2022) {
            $month = $dict[1];
            $day = $dict[2];
            $time= explode(':', $dict[3]);
            $temp = $dict[9];

            fputcsv($outputFile, [$year, $month, $day, intval($time[0]), $temp]);
        }
    }
}

fclose($inputFile);
fclose($outputFile);

