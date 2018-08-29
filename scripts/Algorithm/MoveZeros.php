<?php
/**
 * User: Major
 * Date: 2018/4/2
 * Time: 0:04
 */


/**
 * 时间复杂度O(n)
 */

$new = array();

function moveZeros($arr)
{
    global $new;
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] !== 0) array_push($new, $arr[$i]);
    }
}

$arr = array(1, 2, 3, 4, 0, 5, 6, 0, 7, 8, 0, 10);
moveZeros($arr);
echo count($arr) - count($new);
$new = array_pad($new, count($arr), 0);
print_r($new);
