<?php
/**
 * User: Major
 * Date: 2018/4/2
 * Time: 10:40
 */
function moveZeros($arr)
{
    $k = 0;
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] !== 0) {
            $arr[$k++] = $arr[$i];
        }
    }
    for ($j = $k; $j < count($arr); $j++) {
        $arr[$j] = 0;
    }
    print_r($arr);
}

$arr = array(5, 3, 0, 7, 0, 2);
moveZeros($arr);
