<?php

namespace App\Service\Queue\MNS;

use AliyunMNS\Client;
use AliyunMNS\Exception\MnsException;
use App\Service\Queue\Common\IAsyncMessageRouter;
use App\Service\Queue\Common\IConsumer;
use App\Service\Queue\Common\ReceiveMessageResponse;
use App\Service\Queue\Exception\HandlerNotFound;

$env = \App\Env::getInstance();
$basePath = $env->getBasePath();

include_once "{$basePath}/phplib/aliyun-php-sdk/aliyun-php-sdk-mns/mns-autoloader.php";

class Consumer implements IConsumer
{
    private $client;
    private $queue;

    public function __construct($endPoint, $accessId, $accessKey, $queueName)
    {
        $this->client = new Client($endPoint, $accessId, $accessKey);
        $this->queue = $this->client->getQueueRef($queueName);
    }

    public function receiveMessage(IAsyncMessageRouter $messageRouter)
    {
        $receiptHandler = NULL;
        try {
            // 1. 直接调用receiveMessage函数
            // 1.1 receiveMessage函数接受waitSeconds参数，无特殊情况这里都是建议设置为30
            // 1.2 waitSeconds非0表示这次receiveMessage是一次http long polling，如果queue内刚好没有message，
            //     那么这次request会在server端等到queue内有消息才返回。最长等待时间为waitSeconds的值，最大为30。

            $res = $this->queue->receiveMessage(30);

            $messageId = $res->getMessageId();
            $messageBodyMd5 = $res->getMessageBodyMD5();

            // 2. 获取ReceiptHandle，这是一个有时效性的Handle，可以用来设置Message的各种属性和删除Message。具体的解释请参考：help.aliyun.com/document_detail/27477.html 页面里的ReceiptHandle
            $receiptHandler = $res->getReceiptHandle();

            // 3.初始化ReceiveMessageResponse
            $receiveMessageResponse = new ReceiveMessageResponse();
            $receiveMessageResponse->setIsSucceed($res->isSucceed());
            $receiveMessageResponse->setStatusCode($res->getStatusCode());
            $receiveMessageResponse->setMessageId($res->getMessageId());
            $receiveMessageResponse->setMessageBody($res->getMessageBody());
            $receiveMessageResponse->setMessageBodyMD5($res->getMessageBodyMD5());

            try {
                //寻找Message对应的Handler
                $concreteHandler = $messageRouter->findHandler($receiveMessageResponse);

                // 确认找到了Handler 可以从队列里删除这条消息了
                try {
                    $res = $this->queue->deleteMessage($receiptHandler);

                    //处理消息
                    // Handler内部的异常由Executor处理
                    $messageRouter->processMessage($concreteHandler, $receiveMessageResponse);
                } catch (MnsException $e) {
                    //@todo
                }

            } catch (HandlerNotFound $e) {
                $res = $this->queue->deleteMessage($receiptHandler);
            }

        } catch (MnsException $e) {
            //@todo
        }
    }
}
