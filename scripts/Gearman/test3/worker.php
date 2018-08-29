<?php
$worker = new GearmanWorker();
$worker->addServer('127.0.0.1', 4730);
$worker->addFunction('sum', function ($job) {
    $data = json_decode($job->workload(), true);
    sleep(1);
    $sum = 0;
    for ($i = $data[0]; $i < $data[1]; $i++) {
        $sum += $i;
    }
    return $sum;
});

while ($worker->work()) ;