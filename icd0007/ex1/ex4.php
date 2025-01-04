<?php

$input = '[1, 4, 2, 0]';

function stringToIntegerList(string $input): array
{
    $input = str_replace('[', '', $input);
    $input = str_replace(']', '', $input);
    $list = explode(", ", $input);
    $numbers = [];
    foreach ($list as $n) {
        $numbers[] = intval($n);
    }
    var_dump($numbers);

    return $numbers;

}

// check that the restored list is the same as the input list.
// var_dump(stringToIntegerList($input) === [1, 4, 2, 0]); // should print "bool(true)";
//print print_r(stringToIntegerList($input));