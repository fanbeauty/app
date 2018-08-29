<?php
/**
 * User: Major
 * Date: 2018/3/27
 * Time: 20:44
 */

//$n 表示测试用例数目
fscanf(STDIN, "%d", $n);
$sum = array();
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d", $s);
    fscanf(STDIN, "%[^\n]s", $line);
    $roads = str_split(trim($line));
    $s = 0;
    getLight($roads, $s);
    $sum[$i] = $s;
}

foreach ($sum as $val) {
    echo $val . PHP_EOL;
}

/*
 * 1)如果是xx 则跳过第一个x
 * 2) x. 也跳过第一个x
 * 3) 如果.. 则跳过第一个
 * 4) 如果.X 也跳过第一个，放在第二个上
  */

function getLight($road, &$sum = 0)
{
    for ($j = 0; $j < count($road);) {
        $temp = $road[$j];
        if ($temp == "X" && $road[$j++] == "X") {
            $j = $j + 2;
            continue;
        }
        if ($temp == "X" && $road[$j++] == "." && $road[$j++] == "X") {
            $j = $j + 3;
            $sum++;
        }
        if ($temp == ".") {
            $j = $j + 2;
            $sum++;
        }
    }
}