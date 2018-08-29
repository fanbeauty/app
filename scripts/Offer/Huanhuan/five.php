<?php
/**
 * User: Major
 * Date: 2018/8/27
 * Time: 22:39
 */

/**
 * 用两个栈来模拟队列
 */

$stack1 = new SplStack();
$stack2 = new SplStack();

function mypush($node)
{
    global $stack1;
    $stack1->push($node);
}

function mypop()
{
    global $stack1;
    global $stack2;

    if ($stack1->isEmpty() && $stack2->isEmpty()) {
        return null;
    }
    if (!$stack1->isEmpty() && $stack2->isEmpty()) {
        while (!$stack1->isEmpty()) {
            $stack2->push($stack1->pop());
        }
    }
    $stack2->pop();
}

