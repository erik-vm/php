<?php

function getDaysUnderTempDictionary(float $targetTemp): array
{
    $inputFile = fopen(__DIR__ . '/data/temperatures-filtered.csv', "r");

    $totalTempAndaDays = [];

    while (!feof($inputFile)) {
        $dict = fgetcsv($inputFile);
        if ($dict) {
            $year = $dict[0];
            $temp = $dict[4];
            if ($temp <= $targetTemp) {
                if (isset($totalTempAndaDays[$year])) {
                    $totalTempAndaDays[$year]['totalTemp'] += $temp;
                    $totalTempAndaDays[$year]['count']++;
                } else {
                    $totalTempAndaDays[$year] = ['totalTemp' => $temp, 'count' => 1];
                }
            }
        }
    }
    fclose($inputFile);
    $result = [];
    foreach ($totalTempAndaDays as $year => $data) {

        $result[$year] = abs(round(($data['count'] / 24), 2));
    }
    return $result;
}

//var_dump(getDaysUnderTempDictionary(-10));
function dictToString(array $dict): string
{
    $result = [];

    foreach ($dict as $year => $data) {
        $result[] = $year . " => " . $data;
    }

    return '[' . join(', ', $result) . ']';
}

//print_r(dictToString(getDaysUnderTempDictionary(-10)));