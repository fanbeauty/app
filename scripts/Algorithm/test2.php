<?php
/**
 * User: Major
 * Date: 2018/3/27
 * Time: 20:21
 */

// 1）末尾数能被3整除，就能被3整除
//2) 余1,那就判断 后,1位能否被3整除
// 3) 余2，那就判断后两位能否3整除

fscanf(STDIN, "%[^\n]s", $line);
$fileds = explode(" ", trim($line));

$sum = 0;
for ($i = intval($fileds[0]); $i <= intval($fileds[1]); $i++) {
    //被3整除
    if ($i % 3 == 0) {
        $sum++;
    } //余1
    else if ($i % 3 == 2) {
        $pre = ($i - 1);
        $new = $pre * pow(10, (strlen("$pre") + strlen("$i") - 1)) + $i;
        if ($new % 3 == 0) {
            $sum++;
        }
    }
}

echo $sum;