<?php

ini_set('display_errors', '1');
require_once '../ex1/ex7.php';
require_once '../ex2/functions.php';

$command = $_POST['command'] ?? 'show-form';
$year = $_POST['year'] ?? '2020';
$temp = $_POST['temp'] ?? '1';


if ($command === 'show-form') {
    $page = $_GET['page'] ?? 'days-under-temp';
    if ($page === 'days-under-temp') {
        include 'pages/days-under-temp.php';
    } else {
        include 'pages/avg-winter-temp.php';
    }
} else if ($command === 'days-under-temp') {
    $year = intval($year);
    $temp = floatval($temp);
    $result = getDaysUnderTemp($year, $temp);
    $message = sprintf("%.2f days where under %.2f degrees in %d", $result, $temp, $year);

    include 'pages/result.php';

} else if ($command === 'avg-winter-temp') {
    $winterYears = explode('/', $year);
    $firstYear = intval($winterYears[0]);
    $secondYear = intval($winterYears[1]);
    var_dump($firstYear,$secondYear);
    $result = getAverageWinterTemp($firstYear, $secondYear);
    $message = sprintf("%.2f days where under %.2f degrees in %d", $result, $temp, $year);

    include 'pages/result.php';
} else {
    throw new Error('unknown command: ' . $command);
}


