<?php
/**
 * User: Major
 * Date: 2018/4/6
 * Time: 22:45
 */
/**
 * 给定一个含有 n 个正整数的数组和一个正整数 s , 找到一个最小的连续子数组的长度，使得这个子数组的数字和 ≥  s 。
 * 如果不存在符合条件的子数组，返回 0。
 *举个例子，给定数组 [2,3,1,2,4,3] 和 s = 7,
 *子数组 [4,3]为符合问题要求的最小长度。
 */
function getMinLength($arr, $s)
{
    $l = 0; // [$l....$r]
    $r = -1;
    $sum = 0;
    $min = count($arr);
    while ($l < count($arr)) {
        if ($r + 1 < count($arr) && $sum < $s) {
            $r++;
            $sum += $arr[$r];
        } else {
            $sum -= $arr[$l];
            $l++;
        }

        if ($sum >= $s) {
            if ($r - $l + 1 < $min) $min = $r - $l + 1;
        }
//        echo $l . '--' . $r . '------';
    }
    if ($min == count($arr)) return 0; //在上面操作中，$min没有被更新的话，那么就是没有这个子串之和大于s
    return $min;
}

$arr = array(1, 2, 3);
$s = 100;
echo getMinLength($arr, $s);