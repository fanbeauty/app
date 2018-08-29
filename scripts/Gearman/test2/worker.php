<?php
//创建一个worker
$worker = new GearmanWorker();
$worker->addServer('127.0.0.1', 4730);
$worker->addFunction('sendMail', function ($job) {
    $data = json_decode($job->workload(), true);
    //模拟发送邮件所用时间
    sleep(6);
    echo "发送{$data['email']}邮件成功\n";
});

while ($worker->work()) ;