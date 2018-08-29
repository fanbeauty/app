<?php
/**
 * User: Major
 * Date: 2018/3/27
 * Time: 23:11
 */

function reverse($str)
{
    if (strlen($str) == 1) {
        return $str;
    }
    return reverse(substr($str, 1)) . $str[0];
}


function mypow($x, $n)
{
    if ($n == 0) {
        return 1;
    }
    $t = mypow($x, $n / 2);
    if ($n % 2 == 1) {
        return $x * $t * $t;
    }
    return $t * $t;
}

echo mypow(10,4);


