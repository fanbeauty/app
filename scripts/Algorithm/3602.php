<?php
/**
 * User: Major
 * Date: 2018/4/3
 * Time: 20:38
 */

/**
 * 分析
 *  1 2 3 4 5 6
 *
 *  1 2 2 2 3 4
 *
 *  首先要排一次序
 */

//n来表示几组数
fscanf(STDIN, "%d", $n);
//$arr 用来存输入的数据
$arr = array();
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d", $m);
    fscanf(STDIN, "%[^\n]s", $line);
    $arr[] = explode(" ", trim($line));

    for ($j = 0; $j < count($arr[$i]); $j++) {
        $arr[$i][$j] = intval($arr[$i][$j]);
    }
}

//遍历$arr
//首先进程排序

for ($k = 0; $k < count($arr); $k++) {
    sort($arr[$k]);
    $right = count($arr[$k]) / 2;
    $left = $right--;
    while ($arr[$k][$left] != $arr[$k][$right]){
        $left--;
        $right++;
    }
    if ($left > 0) {
        echo 'YES';
    } else {
        echo 'NO';
    }
    echo PHP_EOL;
}
