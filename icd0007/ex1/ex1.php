<?php

$numbers = [1, 2, '3', 6, 2, 3, 2, 3];

$count = 0;

foreach ($numbers as $n) {
    if ($n=== 3) {
        $count++;
    }
}

print "Found it $count times";

