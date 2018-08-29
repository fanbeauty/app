<?php
/*
//n来表示几组数
fscanf(STDIN, "%d", $n);
//$arr 用来存输入的数据
$arr = array();
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%[^\n]s", $line);
    $arr[] = explode(" ", trim($line));
}

function cancer($arr)
{

}*/

$arr = [
    [3, 10],
    [20, 30],
    [1, 3]
];

usort($arr, 'mySort');

print_r($arr);

//根据时间段第一个时间排序
function mySort($arr)
{
    for ($i = 0; $i < count($arr); $i++) {
        if ((int)$arr[$i][0] < (int)$arr[$i + 1][0]) {
            return 1;
        } else if ((int)$arr[$i][0] == (int)$arr[$i + 1][0]) {
            return 0;
        } else {
            return -1;
        }
    }
}
