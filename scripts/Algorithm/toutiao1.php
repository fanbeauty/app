<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 10:37
 */
/**
 * 先是获取输入的字符
 */
//n来表示几组数
fscanf(STDIN, "%[^\n]s", $mn);
$mnArr = explode(' ', trim($mn));
$m = $mnArr[0];     //M行
$n = $mnArr[1];     //每行N数字


//$all 用来存输入的数据
$all = [];
for ($i = 0; $i < $m; $i++) {
    fscanf(STDIN, "%[^\n]s", $line);
    $all[] = explode(" ", trim($line));
}

//定义一个map
$map = [];


//判断二维数组中一点是否有相邻的点,有相邻点的话，都将其放到map中
function hasNeighbor($x, $y, $all, $count)
{
    global $m,$n;
    $count++;
    array_push($map, $x + $y);
    //左
    if ($y > 0 && $all[$x][$y - 1] == 1) {
        $count++;
    }
    //右
    if ($y-1 < $n && $all[$x][$y + 1] == 1) {
        $count++;
    }
    //上
    if ($x > 0 && $all[$x - 1][$y] == 1) {
        $count++;
    }
    if ($x - 1 < $m && $all[$x + 1][$y] == 1) {
        $count++;
    }
}