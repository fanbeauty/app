<?php
/**
 * User: Major
 * Date: 2018/4/2
 * Time: 13:07
 */


function removeDuplicate($arr)
{
    $k = 0;
    for ($i = 0; $i < count($arr); $i++) {
        $target = $arr[$k];
        if ($arr[$i] != $target) {
            $k++;
            $temp = $arr[$k];
            $arr[$k] = $arr[$i];
            $arr[$i] = $temp;
        }
    }
    var_dump($arr);
}

removeDuplicate(array(1,1,2));