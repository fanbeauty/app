<?php
/**
 * User: Major
 * Date: 2018/4/7
 * Time: 13:47
 */
/**
 * 给定一个字符串，找出不含有重复字符的 最长子串 的长度。
 * 示例：
 * 给定 "abcabcbb" ，没有重复字符的最长子串是 "abc" ，那么长度就是3。
 * 给定 "bbbbb" ，最长的子串就是 "b" ，长度是1。
 * 给定 "pwwkew" ，最长子串是 "wke" ，长度是3。请注意答案必须是一个子串，"pwke" 是 子序列 而不是子串。
 */
error_reporting(0);
/**
 * 双索引技术，也叫滑动窗口
 * 判断一个字符是否出现过，可以通过数组来计频率，时间复杂度O(1)
 */
function getRepeatMinStr($str)
{
    $l = 0; //[$l..$r]
    $r = -1;
    //定义一个数组，来存放字母出现的频率，计数法
    $seq[256] = 0;
    $max = -1;
    while ($l < strlen($str)) {
        if ($r+1 < strlen($str) &&  $seq[$str[$r + 1]] == 0) {
            $r++;
            $seq[$str[$r]]++;
        } else {
            $seq[$str[$l]]--;
            $l++;
        }
        if ($r - $l + 1 > $max) {
            $max = $r - $l + 1;
        }
    }
    return $max;
}

$str = "bbbbab";
echo getRepeatMinStr($str);
