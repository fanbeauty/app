<?php

/**
 * `yield 既是语句也是表达式
 * 1、yield作为语句（类似return语句），会返回$i给调用者。
 * 2、yield作为表达式。获取send函数传递值，赋值给$cmd。
 */

function gen()
{
    for ($i = 1; $i <= 100; $i++) {
        $cmd = (yield $i);
        if ($cmd == 'stop') {
            return;
        }
    }
}

$gen = gen();

$i = 1;
foreach ($gen as $item) {
    echo $item . "\n";
    if ($i >= 10) {
        $gen->send('stop');
    }
    $i++;
}