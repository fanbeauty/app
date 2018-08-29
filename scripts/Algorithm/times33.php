<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 22:31
 */

function mash($key)
{
    $hash = 5381;
    $s = md5($key);
    $seed = 5;
    $len = 32;
    for ($i = 0; $i < $len; $i++) {
        $hash = ($hash << $seed) + $hash + $s{$i};
    }
    return $hash & 0x7FFFFFFF;
}
