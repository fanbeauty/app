<?php
/**
 * 斐波那契数列
 * 1 1 2 3 5 8 13
 */

function fibonacci($n)
{
    if ($n == 1) return 1;
    elseif ($n == 2) return 1;
    else return fibonacci($n - 1) + fibonacci($n - 2);
}

$n = $argv[1];

echo fibonacci($n);
