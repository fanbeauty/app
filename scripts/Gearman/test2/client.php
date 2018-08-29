<?php

$client = new GearmanClient();
$client->addServer('127.0.0.1', 4730);
$ret = $client->doBackground('sendEmail', json_encode(array(
    'email' => 'test@qq.com',
    'title' => '测试异步',
    'body' => 'you look cool',
)));

//继续执行下面的代码
echo '我的内心毫无波澜，甚至还想笑' . PHP_EOL;

do {
    sleep(1);

    //获取任务句柄的状态
    //jobStatus返回的是一个数组
    //第一个，表示工作是否已经知道
    //第二个，工作是否是否在进行
    //第三和第四,分别对应完成百分比的分子与分母
    $status = $client->jobStatus($ret);
    echo "完成情况:{$status[2]}/{$status[3]}\n";

    if (!$status[1]) {
        break;
    }

} while (true);
