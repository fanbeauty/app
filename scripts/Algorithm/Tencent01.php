<?php
/**
 * User: Major
 * Date: 2018/4/5
 * Time: 15:33
 */
//首先接收两个数
fscanf(STDIN, "%[^\n]s", $line);
$numbers = explode(' ', trim($line));
$n = intval($numbers[0]);
$m = intval($numbers[1]);

//首先找到规律，如果2个的话，就是相差2个2 , 一共有8/(2*2)次

$sum = $m * $m * ($n / (2 * $m));

echo $sum;