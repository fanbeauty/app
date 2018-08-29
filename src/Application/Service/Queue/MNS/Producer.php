<?php

namespace App\Service\Queue\MNS;

$env = \App\Env::getInstance();
$basePath = $env->getBasePath();

include_once "{$basePath}/phplib/aliyun-php-sdk/aliyun-php-sdk-mns/mns-autoloader.php";

use AliyunMNS\Client;
use AliyunMNS\Exception\MnsException;
use AliyunMNS\Requests\SendMessageRequest;
use App\Service\Queue\Common\IProducer;
use App\Service\Queue\Common\SendMessageResponse;

class Producer implements IProducer
{
    private $client;
    private $queue;

    public function __construct($endPoint, $accessId, $accessKey, $queueName)
    {
        $this->client = new Client($endPoint, $accessId, $accessKey);
        $this->queue = $this->client->getQueueRef($queueName);
    }

    public function sendMessage($messageBody)
    {
        /*
         * 1.生成一个SendMessageRequest对象
         * 1.1 SendMessageRequest对象本身也包含了DelaySeconds和Priority属性可以设置
         * 1.2 对于Message的属性，请参考help.aliyun.com/document_detail/27477.html
         */
        $request = new SendMessageRequest($messageBody);

        try {
            $res = $this->queue->sendMessage($request);
            //2.消息发送成功
            $response = new SendMessageResponse();
            $response->setIsSucceed($res->isSucceed());
            $response->setStatusCode($res->getStatusCode());
            $response->setMessageId($res->getMessageId());
            $response->setMessageBodyMD5($res->getMessageBodyMD5());
            return $response;
        } catch (MnsException $e) {
            // 4.可能因为网络原因，或MessageBody过大等原因造成造成消息失败，这里CatchException并作出对应处理
            // echo "SendMessage Failed: ".$e ."\n";
            throw $e;
        }

    }

    public function sendDelayProcessingMessage($messageBody, $intervalMillSecond)
    {
        $intervalSecond = round($intervalMillSecond / 1000);
        if ($intervalSecond <= 0) {
            $intervalSecond = 1; //阿里云延迟消息必须大于等于1
        }

        $request = new SendMessageRequest($messageBody, $intervalSecond);

        try {
            $res = $this->queue->sendMessage($request);

            $response = new SendMessageResponse();
            $response->setIsSucceed($res->isSucceed());
            $response->setStatusCode($res->getStatusCode());
            $response->setMessageId($res->getMessageId());
            $response->setMessageBodyMD5($res->getMessageBodyMD5());
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
