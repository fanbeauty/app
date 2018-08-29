<?php

//n来表示几组数
fscanf(STDIN, "%d", $n);
//$arr 用来存输入的数据
$arr = array();
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%[^\n]s", $line);
    $arr[] = explode(" ", trim($line));
}

$arr = [
    1 => [0],
    2 => [5, 3, 0],
    3 => [8, 4, 0],
    4 => [9, 0],
    5 => [9, 0],
    6 => [3, 0],
    7 => [0],
    8 => [7, 9, 0],
    9 => [0],
    10 => [9, 7, 0]
];

//存放关系数组
$map = [];
$flag = [];

foreach ($arr as $k => $v) {
    //访问了这个元素，就把它标记
    array_push($flag, $k);

    $map[$k] = [];
    array_push($map[$k], $k);

    for ($i = 0; $i < count($v) && $v[$i] != 0; $i++) {
        array_push($map[$k], $v[$i]);
    }


}


function getRelation($arr, $one, $two)
{
    foreach ($arr[$two] as $k => $v) {

    }
}