<?php

/**
 * 定义栈的数据结构，请在该类型中实现一个能够得到栈中所含最小元素的min函数
 * （时间复杂度应为O（1））。
 */

$stack = new SplStack();
$stackM = new SplStack();

function mypush($node)
{
    global $stack;
    global $stackM;
    $stack->push($node);
    if ($stackM->isEmpty() || $stackM->top() >= $node) {
        $stackM->push($node);
    }
}

function mypop()
{
    global $stack;
    global $stackM;
    $node = $stack->pop();
    if($node==$stackM->top()){
        $stackM->pop();
    }
    return $node;
}

function mytop()
{
    global $stack;
    return $stack->top();
}

function mymin()
{
    global $stackM;
    return $stackM->top();
}