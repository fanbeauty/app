<?php

/**
 * Base64编码
 * 它是一种基于64个可打印字符来表示二进制数据的表示方法。
 *          它是用64个可打印字符表示二进制所有数据方法。由于2的6次方等于64，
 *      所以可以用每6个位元为一个单元，对应某个可打印字符。我们知道三个字节有24个位元，
 *      就可以刚好对应于4个Base64单元，即3个字节需要用4个Base64的可打印字符来表示。
 *      在Base64中的可打印字符包括字母A-Z、a-z、数字0-9 ，这样共有62个字符，
 *      此外两个可打印符号在不同的系统中一般有所不同。
 *      但是，我们经常所说的Base64另外2个字符是：“+/”。这64个字符，所对应表如下
 */

const BASE = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
/**
 * @param $src
 */
function my_base64_encode($src)
{
    //将原始的3个字节转换为4个字节
    $slen = strlen($src);
    $smod = $slen % 3;
    $snum = floor($slen / 3);

    $desc = array();
    for ($i = 0; $i < $snum; $i++) {
        //读取3个字节
        $arr = array_map('ord', str_split(substr($src, $i * 3, 3)));
        //计算每一个base64的值
        $_dec0 = $arr[0] >> 2;
        $_dec1 = (($arr[0] & 3) << 4) | ($arr[1] >> 4);
        $_dec2 = (($arr[1] & 0xF) << 2) | ($arr[2] >> 6);
        $_dec3 = $arr[2] & 0x3F;
        $desc = array_merge($desc, array(BASE[$_dec0], BASE[$_dec1], BASE[$_dec2], BASE[$_dec3]));
    }

    if ($smod == 0) return implode('', $desc);

    //计算非3倍数字节
    $_arr = array_map('ord', str_split(substr($src, $snum * 3, 3)));
    $_dec0 = $_arr[0] >> 2;
    //只有一个字节
    if (!isset($_arr[1])) {
        $_dec1 = (($_arr[0] & 3)) << 4;
        $_dec2 = $_dec3 = "=";
    } else {
        //有两个字节
        $_dec1 = ((($_arr[0] & 3)) << 4) | ($_arr[1] >> 4);
        $_dec2 = BASE[($_arr[1] & 7) << 2];
        $_dec3 = "=";
    }
    $desc = array_merge($desc, array(BASE[$_dec0], BASE[$_dec1], $_dec2, $_dec3));
    return implode('', $desc);
}

echo my_base64_encode("hello my name is jac");