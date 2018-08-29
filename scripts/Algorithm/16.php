<?php
/**
 * User: Major
 * Date: 2018/4/11
 * Time: 16:18
 */
/*
给定一个包括 n 个整数的数组 S，找出 S 中的三个整数使得他们的和与给定的数 target 最接近。返回这三个数的和。假定每组输入只存在一个答案。
例如，给定数组 S = {-1 2 1 -4}, 并且 target = 1.
与 target 最接近的三个数的和为 2. (-1 + 2 + 1 = 2).
 */
function getNearSum($arr, $target)
{
    $ret = $arr[0] + $arr[1] + $arr[2];
    sort($arr);
    for ($i = 0; $i < count($arr) - 2; $i++) {
        $j = $i + 1;
        $k = count($arr) - 1;
        while ($j < $k) {
            $sum = $arr[$i] + $arr[$j] + $arr[$k];
            if ($sum > $target) {
                $k--;
            } else {
                $j++;
            }
            if (abs($sum - $target) < abs($ret - $target)) {
                $ret = $sum;
            }
        }
    }
    return $ret;
}

$arr = [-1, 2, 1, -4];
echo getNearSum($arr, 1);