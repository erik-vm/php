<?php

$list = [1, 2, 3, 2, 6];

function isInList($list, $target): bool
{
    foreach ($list as $n) {
        if ($n === $target) {
            return true;
        }
    }

    return false;
}



