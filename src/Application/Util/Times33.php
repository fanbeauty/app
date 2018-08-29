<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 15:09
 */

namespace App\Util;

class Times33
{
    public static function getHash($key)
    {
        $md5str = md5($key);
        $hash = 5381;
        $seed = 5;
        $len = 32;
        for ($i = 0; $i < $len; $i++) {
            $hash = ($hash << $seed) + $hash + $md5str{$i};
        }
        return $hash & 0x7FFFFFFF;
    }
}
