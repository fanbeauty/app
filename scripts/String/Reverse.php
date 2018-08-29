<?php

//递归做法
function reverse($str)
{
    $len = strlen($str);
    if ($len == 1) {
        return $str;
    } else {
        $subStr = substr($str, 0, $len - 1);
        $endChar = $str[$len - 1];
        return $endChar . reverse($subStr);
    }
}

//首尾遍历
function change(&$str)
{
    $len = strlen($str);
    $i = 0;
    $j = $len - 1;
    while ($i <= $j) {
        list($str[$i], $str[$j])=swap($str[$i], $str[$j]);
        $i++;
        $j--;
    }
}

function swap($a, $b)
{
   return [$b,$a];
//    list($a, $b) = [$b, $a];
}


/**
 *
 * abcdefg
 *
 * cdbfgab
 *
 *
 */