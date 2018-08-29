<?php
/**
 * User: Major
 * Date: 2018/8/27
 * Time: 20:53
 */
/**
 * 在一个二维数组中（每个一维数组的长度相同），
 * 每一行都按照从左到右递增的顺序排序，
 * 每一列都按照从上到下递增的顺序排序。
 * 请完成一个函数，输入这样的一个二维数组和一个整数，判断数组中是否含有该整数。
 */

/**
 * [
 *    [1,2,3,4],
 *    [5,6,7,8],
 *    [9,10,11,12],
 *    [13,14,15,16]
 * ]
 */

function Find($target, $arr)
{
    $len = count($arr);
    $i = 0;
    $j = $len - 1;

    while ($i < $len && $j >= 0) {
        if ($arr[$i][$j] > $target) $j--;
        elseif ($arr[$i][$j] < $target) $i++;
        else
            return true;

    }
    return false;
}

$arr = [
    [1, 2, 3, 4],
    [5, 6, 7, 8],
    [9, 10, 11, 12],
    [13, 14, 15, 16]
];

$target = $argv[1];

$bool = Find($target, $arr);

var_dump($bool);

