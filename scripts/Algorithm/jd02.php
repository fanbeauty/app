<?php
/**
 * User: Major
 * Date: 2018/4/9
 * Time: 20:23
 */
fscanf(STDIN, "%d", $n);
$arr = array();
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%d", $arr[$i]);
}
for ($j = 0; $j < count($arr); $j++) {
    //与1 与=1 表示是奇偶
    if (($arr[$j] & 1) == 1) {
        echo 'No' . PHP_EOL;
    } else {
        $temp = $arr[$j];
        while (($temp & 1) == 0) {
            $temp = $temp/ 2;
        }
        echo $temp . ' ' . $arr[$j] / $temp . PHP_EOL;
    }
}