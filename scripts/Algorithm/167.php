<?php
/**
 * User: Major
 * Date: 2018/4/4
 * Time: 23:55
 */

function twoSum($arr, $target)
{
    $i = 0;
    $j = count($arr) - 1;
    while ($i < $j) {
        if ($arr[$i] + $arr[$j] == $target) return array($i+1, $j+1);
        else if ($arr[$i] + $arr[$j] > $target) $j--;
        else $i++;
    }
}

$arr = array(2, 7, 11, 15);
$target = 9;
$ret = twoSum($arr, $target);
var_dump($ret);