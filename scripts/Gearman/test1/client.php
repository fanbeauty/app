<?php
//创建一个客户端
$client = new GearmanClient();
//添加一个job服务
$client->addServer('127.0.0.1', 4730);
//doNormal是同步的，等待worker处理完成后范湖结果
//建议不要使用do()了
$ret = $client->doNormal('sum', serialize(array(10, 10)));

if ($ret) {
    echo '计算结果是:', $ret, '\n';
}