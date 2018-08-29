<?php
/**
 * User: Major
 * Date: 2018/4/12
 * Time: 14:11
 */
/*
给定一个字符串数组，将相同字谜组合在一起。（字谜是指颠倒字母顺序而成的字）
例如，给定 ["eat", "tea", "tan", "ate", "nat", "bat"]，返回：
[
    ["ate", "eat","tea"],
    ["nat","tan"],
    ["bat"]
]
*/
/**
 * 思路，先把每个单词进行排序
 *
 * 1.array_map()
 * 2.闭包，如果需要传递外部参数，需要使用use关键字
 * 3.字符串排序
 *      str_split()
 *      sort()
 *      implode()
 */
function getSameString($arr)
{
    //O(n^2logn)
    $temp = $arr;
    $new = array_map(function ($item) {
        return sortStr($item);
    }, $temp);

    //O(n)
    $ret = array();
    for ($i = 0; $i < count($arr); $i++) {
        if (!array_key_exists($new[$i], $ret)) {
            $ret[$new[$i]] = array();
        }
        array_push($ret[$new[$i]], $i);
    }

    //O(n^2)
    $res = array();
    foreach ($ret as $values) {
        /*$temp = array();
        for ($k = 0; $k < count($values); $k++) {
            array_push($temp, $arr[$values[$k]]);
        }*/
        $temp = array_map(function ($item) use ($arr) {
            return $arr[$item];
        }, $values);
        array_push($res, $temp);
    }
    return $res;
}

function sortStr($str)
{
    $arr = str_split($str);
    sort($arr);
    return implode('', $arr);
}

$arr = ["eat", "tea", "tan", "ate", "nat", "bat"];

$ret = getSameString($arr);
print_r($ret);

/**
 * Array
 * (
 * [0] => Array
 * (
 * [0] => eat
 * [1] => tea
 * [2] => ate
 * )
 * [1] => Array
 * (
 * [0] => tan
 * [1] => nat
 * )
 * [2] => Array
 * (
 * [0] => bat
 * )
 * )
 */