<?php
$client = new GearmanClient();
$client->addServer('127.0.0.1', 4730);
$client->setCompleteCallback(function ($task) {
    echo $task->data() . PHP_EOL;
});

//计算1到500的累加和
//添加5个任务队列
$client->addTask('sum', json_encode(array(1, 100)));
$client->addTask('sum', json_encode(array(100, 200)));
$client->addTask('sum', json_encode(array(200, 300)));
$client->addTask('sum', json_encode(array(300, 400)));
$client->addTask('sum', json_encode(array(400, 500)));

//运行队列中的任务
$client->runTasks();