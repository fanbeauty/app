<?php
/**
 * User: Major
 * Date: 2018/4/2
 * Time: 11:09
 */

/*
 * 时间复杂度O(n)
 * 空间复杂度O(1)
 */
function moveZeros($arr)
{
    $k = 0;
    for ($i = 0; $i < count($arr); $i++) {
        if ($arr[$i] != 0) {
            if ($k != $i) {
                $temp = $arr[$i];
                $arr[$i] = $arr[$k];
                $arr[$k] = $temp;
            }
            $k++;
        }
    }
    print_r($arr);
}

function swap($a, $b)
{
    $a = $a ^ $b;
    $b = $a ^ $b;
    $a = $a ^ $b;
}

moveZeros(array(1, 3, 5, 0, 8, 0, 10));