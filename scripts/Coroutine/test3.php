<?php

require 'Scheduler.php';
require 'Task.php';
require 'SystemCall.php';

function getTaskId()
{
    return new SystemCall(
        function (Task $task, Scheduler $scheduler) {
            $task->sendValue($task->getTaskId());
            $scheduler->schedule($task);
        }
    );
}


function newTask(Generator $coroutine)
{
    return new SystemCall(
        function (Task $task, Scheduler $scheduler) use ($coroutine) {
            $task->sendValue($scheduler->newTask($coroutine));
            $scheduler->schedule($task);
        }
    );
}

function killTask($tid)
{
    return new SystemCall(
        function (Task $task, Scheduler $scheduler) use ($tid) {
            $task->sendValue($scheduler->killTask($tid));
            $scheduler->schedule($task);
        }
    );
}

function childTask()
{
    $tid = (yield getTaskId());
    while (true) {
        echo "Child task $tid still alive!\n";
        yield;
    }
}

function task(){
    $tid = (yield getTaskId()); //tid = 1
    $childTid = (yield newTask(childTask()));
    for ($i=0;$i<=6;$i++){
        echo "Parent task $tid iteration $i.\n";
        yield;
        if($i==3) yield killTask($childTid);
    }
}

$scheduler = new Scheduler();
$scheduler->newTask(task());
$scheduler->run();