<?php
/**
 * User: Major
 * Date: 2018/4/7
 * Time: 15:41
 */
/*
 * 给定一个字符串s和一个非空字符串p，找出p中的所有事s的字符串的子串，返回这些
 * 子串的起始索引
 * 如 s="cbaebabacd" p="abc" 返回[0,6]
 *  s="abab" p="ba" 返回[0,1,2]
 */
function findSubstrStart($s, $p)
{
    //双索引技术
    $l = 0;  //[$l....$r]
    $r = -1;
    $len = strlen($p);
    $res = array();
    while ($l < count($s)) {
        if ($r + 1 < count($s) && strpos($p, $s[$r + 1]) !== false) {
            $r++;
            if ($r - $l + 1 == $len) {
                array_push($arr, $l);
                $l++;
            }
        } else {
            $r++;
        }


        echo $r;

    }
    return $res;
}

$s = "cbaebabacd";
$p = "abc";
var_dump(findSubstrStart($s, $p));