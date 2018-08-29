<?php
/**
 * User: Major
 * Date: 2018/4/11
 * Time: 14:07
 */
/*
 给定一个含有 n 个整数的数组 S，数列 S 中是否存在元素 a，b，c 和 d 使 a + b + c + d = target ？
    请在数组中找出所有满足各元素相加等于特定值 的 不重复 组合。
    注意：解决方案集不能包含重复的四元组合。
    例如，给定数组 S = [1, 0, -1, 0, -2, 2]，并且给定 target = 0。
    示例答案为：
    [
      [-1,  0, 0, 1],
      [-2, -1, 1, 2],
      [-2,  0, 0, 2]
    ]
 */
/*
 * 思路，转化为3sum问题，确定了一个值$arr[$i]，在另外序列中找到和为 -$arr[$i]
 * 在将 3sum,转化为 2sum问题
 */

function get4Sum($arr, $target)
{
    sort($arr); //排序 [-2 -1 0 0 1 2]
    $ret = array();
    for ($i = 0; $i < count($arr); $i++) {
        $new_target = $target - $arr[$i];
        for ($j = $i + 1; $j < count($arr); $j++) {
            $new_new_target = $new_target - $arr[$j];
            $k = $j + 1;
            $n = count($arr) - 1;
            while ($k < $n) {
                if ($arr[$k] + $arr[$n] > $new_new_target) $n--;
                else if ($arr[$k] + $arr[$n] < $new_new_target) $k++;
                else {
                    $temp = array();
                    $temp[] = $arr[$i];
                    $temp[] = $arr[$j];
                    $temp[] = $arr[$k];
                    $temp[] = $arr[$n];
                    $ret[] = $temp;
                    while ($k < $n && $arr[$n - 1] == $arr[$n]) $n--;
                    $n--;
                    while ($k < $n && $arr[$k + 1] == $arr[$k]) $k++;
                    $k++;
                }
            }
            while ($j + 1 < count($arr) && $arr[$j + 1] == $arr[$j]) $j++;
        }
        while ($i + 1 < count($arr) && $arr[$i + 1] == $arr[$i]) $i++;
    }
    return $ret;
}

$arr = [1, 0, -1, 0, -2, 2];
$ret = get4Sum($arr, 0);
print_r($ret);



