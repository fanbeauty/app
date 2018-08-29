<?php
/**
 * User: Major
 * Date: 2018/4/12
 * Time: 12:38
 */
/*
 * 三个有序数组，找出第n大的
 * [1,2,3,5,5]
 * [2,3,6,9,89]
 * [-2,-1,0,3]
 */

function getThirdMax($arr1, $arr2, $arr3, $n)
{

    $temp = array();
    $i = count($arr1) - 1;
    $j = count($arr2) - 1;
    $k = count($arr3) - 1;
    $len = count($arr1) + count($arr2) + count($arr3) - 1;
    for ($x = 0; $x < $len; $x++) {
        $temp1 = $arr1[$i];
        $temp2 = $arr2[$j];
        $temp3 = $arr1[$i];

        $max = getMax($temp1, $temp2, $temp3);
        if ($max == $temp1 && $i - 1 >= 0) $i--;
        else if ($max == $temp2 && $j - 1 >= 0) $j--;
        else if ($k - 1 >= 0) $k--;

        if (!array_search($max, $temp)) {
            array_push($temp, $max);
            if (count($temp) == $n) break;
        }
    }
//    return $temp[count($temp) - 1];
    return $temp;
}

function getMax($a, $b, $c)
{
    if ($a >= $b && $a >= $c) return $a;
    if ($b >= $a && $b >= $a) return $b;
    if ($c >= $a && $c >= $b) return $c;
}


$a = [1, 2, 3, 5, 5];
$b = [2, 3, 6, 9, 89];
$c = [-2, -1, 0, 3];

$ret = getThirdMax($a, $b, $c, 100);
print_r($ret);