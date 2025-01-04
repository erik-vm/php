<?php

require_once '../ex1/ex7.php'; // use existing code
require_once '../ex1/ex8.php';
require_once 'functions.php'; // separate functions from main program

$opts = getopt('c:y:t:', ['command:', 'year:', 'temp:']);

$command = $opts['command'] ?? $opts['c'] ?? null;

if ($command === 'days-under-temp') {
    $year = $opts['year'] ?? $opts['y'] ?? null;
    $temp = $opts['temp'] ?? $opts['t'] ?? null;
    if ($year !== null && $temp !== null) {
        $result = getDaysUnderTemp(intval($year), floatval($temp));
        print_r($result);
    } else {
        showError("Parameters missing or invalid!");
    }

} else if ($command === 'days-under-temp-dict') {
    $target = $opts['temp'] ?? $opts['t'] ?? null;
    if ($target !== null) {
        $result = getDaysUnderTempDictionary($target);
        print_r(dictToString($result));
    } else {
        showError("Parameters missing or invalid!");
    }
} else if ($command === 'avg-winter-temp') {
    $years = $opts['year'] ?? $opts['y'] ?? null;
    if ($years !== null) {
        $list = explode('/', $years);
        $result = getAverageWinterTemp(intval($list[0]), intval($list[1]));
        print_r($result);
    } else {
        showError("Parameters missing or invalid!");
    }

} else {
    showError('command is missing or is unknown');
}

function showError(string $message): void
{
    fwrite(STDERR, $message . PHP_EOL);
    exit(1);
}
