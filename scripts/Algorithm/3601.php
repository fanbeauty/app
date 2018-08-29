<?php
/**
 * User: Major
 * Date: 2018/4/3
 * Time: 20:18
 */

//n来表示几组数
fscanf(STDIN, "%d", $n);
//$arr 用来存输入的数据
$arr = array();
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%[^\n]s", $line);
    $arr[] = explode(" ", trim($line));
}

//遍历$arr
for ($j = 0; $j < count($arr); $j++) {
    $sum = 0;
    for ($k = 0; $k < count($arr[$j]); $k++) {
        $sum += intval($arr[$j][$k]);
    }
    if ($sum % 5 == 0) {
        echo $sum / 5;
    } else {
        echo -1;
    }
}