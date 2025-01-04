<?php

$sampleData = [
    ['type' => 'apple', 'weight' => 0.21],
    ['type' => 'orange', 'weight' => 0.18],
    ['type' => 'pear', 'weight' => 0.16],
    ['type' => 'apple', 'weight' => 0.22],
    ['type' => 'orange', 'weight' => 0.15],
    ['type' => 'pear', 'weight' => 0.19],
    ['type' => 'apple', 'weight' => 0.09],
    ['type' => 'orange', 'weight' => 0.24],
    ['type' => 'pear', 'weight' => 0.13],
    ['type' => 'apple', 'weight' => 0.25],
    ['type' => 'orange', 'weight' => 0.08],
    ['type' => 'pear', 'weight' => 0.20],
];


function getAverageWeightsByType(array $list): array
{
    foreach ($list as $fruit) {
        $type = $fruit['type'];
        $weight = $fruit['weight'];

        if (isset($fruitWeights[$type])) {
            $fruitWeights[$type]['totalWeight'] += $weight;
            $fruitWeights[$type]['count']++;
        } else {
            $fruitWeights[$type] = ['totalWeight' => $weight, 'count' => 1];
        }
    }

    $averageWeights = [];

    foreach ($fruitWeights as $type => $data) {
        $averageWeights[$type] = round($data['totalWeight'] / $data['count'], 2); // Round to 2 decimal places
    }
    return $averageWeights;
}

// testimiseks
 print_r(getAverageWeightsByType($sampleData));