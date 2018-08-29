<?php

function adder()
{
    $sum = 0;
    return function ($v) {
        global $sum;
        $sum += $v;
        return $sum;
    };
}

$a = adder();

for ($i = 0; $i < 10; $i++) {
    echo $a($i);
}