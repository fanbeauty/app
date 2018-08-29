<?php
/**
 * User: Major
 * Date: 2018/4/12
 * Time: 16:16
 */
/*
 * 给定二维平面上有 n 个点，求最多有多少点在同一条直线上。
 */
// $arr = [[1,2],[1,3],[2,2],[2,4],[1,9],[2,8]]
/*
 * 思路，以某一点为枢纽，求其他点到这一点的斜率，创建关联数组
 */
function getMaxPointNums($arr)
{
    $max = 0;
    for ($i = 0; $i < count($arr); $i++) {
        $slope = array();
        for ($j = 0; $j < count($arr); $j++) {
            if ($i != $j) {
                $ang = calSlope($arr[$i], $arr[$j]);
                if (array_key_exists("$ang", $slope)) {
                    $slope[$ang]++;
                } else {
                    $slope[$ang] = 2;
                }
            }
        }
        print_r($slope);
        if ($max < max($slope)) {
            $max = max($slope);
        }
    }
    return $max;
}

function calSlope($arr1, $arr2)
{
    $x1 = $arr1[0];
    $y1 = $arr1[1];

    $x2 = $arr2[0];
    $y2 = $arr2[1];

    if ($x1 == $x2) return 'rightangle';
    return ($y2 - $y1) / ($x2 - $x1);
}

$arr = [[1, 2], [1, 3], [2, 2], [2, 4], [1, 9], [2, 8], [12, 5]];

echo getMaxPointNums($arr);