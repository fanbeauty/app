<?php
/**
 * User: Major
 * Date: 2018/4/4
 * Time: 12:43
 */
/*
 * 在未排序的数组中找到第 k 个最大的元素。请注意，它是数组有序排列后的第 k 个最大元素，而不是第 k 个不同元素。
 * 例如，
 * 给出 [3,2,1,5,6,4] 和 k = 2，返回 5。
 */
function selectKmax($arr, $l, $r, $k, $n)
{
    $i = $l;
    $j = $r;
    if ($l <= $r) {
        $temp = $arr[$l];
        while ($i < $j) {
            while ($i < $j && $arr[$j] > $temp) $j--;
            if ($i < $j) {
                $arr[$i] = $arr[$j];
                $i++;
            }
            while ($i < $j && $arr[$i] < $temp) $i++;
            if ($i < $j) {
                $arr[$j] = $arr[$i];
                $j--;
            }
        }
        $arr[$i] = $temp;
        /*
         * 此处还要加一个判断
         *  如果当前i所处的位置，右边的数量比k要大，则右递归
         *  如果当前i所处的位置，右边的数量要比k小，则左递归
         */
        if ($i + $k == $n) {
            return $arr[$i];
        } else if ($i + $k < $n) {
            return selectKmax($arr, $i + 1, $r, $k, $n);
        } else {
            return selectKmax($arr, $l, $i - 1, $k, $n);
        }
    }
}

$arr = array(3, 2, 1, 5, 6, 4);
$l = 0;
$r = 5;
$k = 5;
$n = 6;
echo selectKmax($arr, $l, $r, $k, $n);