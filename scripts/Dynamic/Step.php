<?php

/*
 * F(n) = F(n-1)+F(n-2)
 */

class Step
{
    public static $map = array();

    /**
     * 时间复杂度是指数级别的 O(2^n)
     * @param $n
     * @return int
     */
    public static function resolve1($n)
    {
        if ($n < 1) return 0;
        if ($n == 1) return 1;
        if ($n == 2) return 2;
        return self::resolve1($n - 1) + self::resolve1($n - 2);
    }

    /**
     * 改进一：
     * 由于上一部代码有大量重复计算，现在用一个缓存表，来存储数据，只要缓存表里有的数据，直接从里面取即可
     * 此时 时间复杂度O(n)
     * 空间复杂度 O(n)
     * @param $n
     * @return int
     */
    public static function resolve2($n)
    {
        if ($n < 1) return 0;
        if ($n == 1) return 1;
        if ($n == 2) return 2;
        if (array_key_exists($n, self::$map)) {
            return self::$map[$n];
        } else {
            $ret = self::resolve2($n - 1) + self::resolve2($n - 2);
            self::$map[$n] = $ret;
            return $ret;
        }
    }

    /**
     * 改进三
     * 思路倒逆，从下往上算
     * 这就是动态规划，采用了简洁的自底向上的推导方式
     */
    public static function resolve3($n)
    {
        $f1 = 1;
        $f2 = 2;
        for ($i = 3; $i <= $n; $i++) {
            $temp = $f2 + $f1;
            $f1 = $f2;
            $f2 = $temp;
        }
        return $temp;
    }

}

echo Step::resolve3(40);