<?php
/**
 * User: Major
 * Date: 2018/4/1
 * Time: 19:43
 */
function is2mi($n)
{
    if (($n & ($n - 1)) == 0) {
        echo 'Yes';
        return;
    }
    echo 'No';
}

is2mi(31);

/**
 * 16
 * 10000
 * 01111
 * 00000
 */