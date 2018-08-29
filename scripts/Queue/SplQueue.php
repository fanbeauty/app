<?php

class Queue
{
    public static function test1()
    {
        $sql_queue = new SplQueue();
        $sql_queue->push(1);
        $sql_queue->push(2);
        $sql_queue->push(3);
        $sql_queue->push(4);
        $sql_queue->push(5);
        $sql_queue->push(6);
        echo $sql_queue->dequeue();
    }
}


Queue::test1();