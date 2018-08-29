<?php
/**
 * User: Major
 * Date: 2018/4/12
 * Time: 13:38
 */
/*
 给定四个包含整数的数组列表 A , B , C , D ,计算有多少个元组 (i, j, k, l) ，使得 A[i] + B[j] + C[k] + D[l] = 0。
为了使问题简单化，所有的 A, B, C, D 具有相同的长度 N，且 0 ≤ N ≤ 500 。所有整数的范围在 -228 到 228 - 1 之间，最终结果不会超过 231 - 1 。
例如:
输入:
A = [ 1, 2]
B = [-2,-1]
C = [-1, 2]
D = [ 0, 2]
输出:
2
解释:
两个元组如下:
1. (0, 0, 0, 1) -> A[0] + B[0] + C[0] + D[1] = 1 + (-2) + (-1) + 2 = 0
2. (1, 1, 0, 0) -> A[1] + B[1] + C[0] + D[0] = 2 + (-1) + (-1) + 0 = 0
 */

/**
 * 利用查找表思想，先将c+d各种情况放到查找表中,PHP->关联数组
 *array_key_exists
 * array_search
 * array_push
 * array_pop
 * array_shift
 * array_unshift
 * array_sum
 * in_array
 * array_keys
 * array_values
 * array_unique
 * array_sort
 * reverse
 * array_splice
 * array_slice
 * shuffle()
 * array_pad
 * array_chunk
 */

/**
 *时间复杂度O（n^2）
 *空间复杂度O（n^2）
 */
function get4Sum($arr1, $arr2, $arr3, $arr4)
{
    $temp1 = array();
    for ($i = 0; $i < count($arr3); $i++) {
        for ($j = 0; $j < count($arr4); $j++) {
            $sum = $arr3[$i] + $arr4[$j];
            if (array_key_exists($sum, $temp1)) $temp1[$sum]++;
            else $temp1[$sum] = 1;
        }
    }

    $res = 0;
    for ($m = 0; $m < count($arr1); $m++) {
        for ($n = 0; $n < count($arr2); $n++) {
            $sum = $arr1[$m] + $arr2[$n];
            if (array_key_exists(-$sum, $temp1)) {
                $res += $temp1[-$sum];
            }
        }
    }
    return $res;
}

$arr1 = [1, 2];
$arr2 = [-2, -1];
$arr3 = [-1, 2];
$arr4 = [0, 2];
$res = get4Sum($arr1, $arr2, $arr3, $arr4);
print_r($res);