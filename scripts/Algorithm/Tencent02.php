<?php
/**
 * User: Major
 * Date: 2018/4/5
 * Time: 15:42
 */
//首先获取到取得的数字
fscanf(STDIN, "%d", $total);
fscanf(STDIN, "%[^\n]s", $line);
$numbers = explode(' ', trim($line));
$durationA = intval($numbers[0]);
$numbersA = intval($numbers[1]);
$durationB = intval($numbers[2]);
$numbersB = intval($numbers[3]);

//其中，duration表示歌曲长度，numbers表示这首歌的数量
/*if ($durationA + $durationB == $total) {
    echo ($numbersA * $numbersB) % 1000000007;
}*/

/*
 * 思路：k = Ax + By (A、B分别为长度)
 * 如何求x,y
 * 先求出x,y的组合
 */
$arr = array();

for ($i = 0; $i <= $numbersA; $i++) {
    for ($j = 0; $j <= $numbersB; $j++) {
        if ($i * $durationA + $j * $durationB == $total) {
            $temp = array($i, $j);
            $arr[] = $temp;
        }
    }
}

//遍历各种组合
$sum = 0;
for ($k = 0; $k < count($arr); $k++) {
    $x = methods($numbersA, $arr[$k][0]);
    $y = methods($numbersB, $arr[$k][1]);
    if ($x == 0) {
        $sum += $y;
    }
    if ($y == 0) {
        $sum += $x;
    }
    if ($x != 0 && $y != 0) {
        $sum += $x * $y;
    }
}
//输出$sum
echo $sum % 1000000007;


/*
 * 写一个函数，在n个物品中，取m个有多少种方法
 */
function methods($sum, $k)
{
    if ($k == 0) return 0;
    $sum1 = 1;
    $sum2 = 1;
    for ($i = 0; $i < $k; $i++) {
        $sum1 *= ($sum - $i);
        $sum2 *= ($i + 1);
    }
    return $sum1 / $sum2;
}