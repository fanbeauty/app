<?php
/**
 * User: Major
 * Date: 2018/4/6
 * Time: 18:13
 */
/**
 * 给定 n 个正整数 a1，a2，...，an，其中每个点的坐标用（i, ai）表示。 画 n 条直线，使得线 i 的两个端点处于（i，ai）和（i，0）处。
 * 请找出其中的两条直线，使得他们与 X 轴形成的容器能够装最多的水。
 */
/*
 *
 */
/*
 * 给定两点坐标，求出他们与X轴构成的容器
 */
function getTwoPoint($height, $a, $b)
{
    $temp = min(array($height[$a], $height[$b]));
    return abs($a - $b) * $temp;
}

//echo getTwoPoint($height,0,2);

function maxArea($height)
{
    $l = 0;
    $r = count($height) - 1;
    $max_res = 0; //不断更新
    while ($l < $r) {
        $res = getTwoPoint($height, $l, $r);
        if ($res > $max_res) {
            $max_res = $res;
        }
        if ($height[$l] < $height[$r]) {
            $l++;
        } else {
            $r--;
        }
    }
    return $max_res;
}

$height = array(2, 3, 4, 5, 18, 17, 6);
echo maxArea($height);