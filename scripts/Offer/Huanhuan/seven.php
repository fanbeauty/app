<?php
/**
 * User: Major
 * Date: 2018/8/27
 * Time: 23:20
 */

/**
 * 大家都知道斐波那契数列，现在要求输入一个整数n，请你输出斐波那契数列的第n项（从0开始，第0项为0）。
 * n<=39
 */

/**
 * 1
 * 1
 * 2
 * 3
 * 5
 * 8
 */

function Fibonacci($n)
{
    if ($n == 1 || $n == 2) {
        return 1;
    }
    return Fibonacci($n - 1) + Fibonacci($n - 2);
}

echo Fibonacci(6);