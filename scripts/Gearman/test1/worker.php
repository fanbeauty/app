<?php
//创建一个worker
$worker = new GearmanWorker();
//添加一个job服务
$worker->addServer('127.0.0.1', 4730);
//注册一个回调函数，用于业务处理
$worker->addFunction('sum', function ($job) {
    //workload()获取客户端发送来的序列化数据
    $data = unserialize($job->workload());
    return array_sum($data);
});

//死循环
while (true) {
    //等待job提交的任务
    $ret = $worker->work();
    if ($worker->returnCode() != GEARMAN_SUCCESS) {
        break;
    }
}