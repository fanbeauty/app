<?php
/**
 * User: Major
 * Date: 2018/4/1
 * Time: 22:31
 */
function BinarySearch($arr, $target)
{
    $low = 0;
    $high = count($arr) - 1;
    while ($low <= $high) // [$low...$high]的范围内寻找$target
    {
        $mid = $low + floor(($high - $low) / 2);
        if ($arr[$mid] == $target) return true;
        else if ($arr[$mid] > $target) $high = $mid - 1;
        else $low = $mid + 1;
    }
    return false;
}

var_dump(BinarySearch(array(1, 2, 3, 4, 5, 6, 7, 8, 9), 4));

/*
 *0 8  4  $arr[4] >4 --> high = 4-1 =3
 *0 3  1  $arr[1] <4 --> low = 1+1 = 2
 *2 3 2 $arr[2] <4 --> low = 2+1 = 3
 *3 3  以上程序有bug，
 *
 * 应该是 while($low<=$high)
 *
 */
