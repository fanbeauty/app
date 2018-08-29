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
fscanf(STDIN, "%d", $n);
//$arr 用来存输入的数据
$arr = array();
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%[^\n]s", $line);
    $arr[] = explode(" ", trim($line));
}


//写一个函数
function getperiod($arr)
{
    $min = min($arr);
    for ($i = 0; $i < count($arr); $i++) {
        for ($j = 0; $j < count($arr); $j++) {
            if ($arr[$i] + $arr[$j] <= $arr[count($arr) - 1] && $arr[$i] + $arr[$j] >= $arr[0] && in_array($arr[$i] + $arr[$j], $arr) && $j < $min) {
                $min = $arr[$j];
            }
        }
    }
    return $min;
}
//
//$arr = [3, 2, 4, 6];
//echo getperiod($arr);




for ($i = 0; $i < count($arr); $i++) {
    $a = $arr[$i];
    $a = array_map(function($item){return intval($item);},$a);
    echo getperiod($a) . PHP_EOL;
}
