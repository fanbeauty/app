<?php
/**
 * User: Major
 * Date: 2018/4/2
 * Time: 22:47
 */

//时间复杂度0（n）
//空间复杂度 0（1）
function sortColor($arr)
{
    //[0...zeros...two...2]
    $zero = -1;  // [0,$zeros]
    $two = count($arr); // [$two , n-1]
    for ($i = 0; $i < $two;) {
        if ($arr[$i] == 1) {
            $i++;
        } else if ($arr[$i] == 2) {
            $two--;
            swap($arr[$i], $arr[$two]);
        } else {
            $zero++;
            swap($arr[$i], $arr[$zero]);
            $i++;
        }
    }
    print_r($arr);
}

function swap(&$a,&$b)
{
    $temp = $a;
    $a = $b;
    $b = $temp;
}

sortColor(array(1, 2, 0, 1, 2, 1, 2, 0, 0));