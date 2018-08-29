<?php

namespace App\Service\Queue\Common;

interface IAsyncMessageRouter
{
    /**
     * 注册Handler
     * @param IAsyncHandler $handler
     * @return mixed
     */
    public function registerHandler(IAsyncHandler $handler);

    /**
     * 通过handler类名 找到handler
     * @param $className
     * @return mixed
     */
    public function getHandler($className);

    /**
     * 获得消费者
     * @return mixed
     */
    public function getConsumer();

    /**
     * 发送即时消息
     * @param IAsyncHandler $handler
     * @param $message
     * @return mixed
     */
    public function sendMessage(IAsyncHandler $handler, $message);

    /**
     * 发送延时消息
     * @param IAsyncHandler $handler
     * @param $message
     * @param $intervalMillsSecond
     * @return mixed
     */
    public function sendDelayProcessingMessage(IAsyncHandler $handler, $message, $intervalMillsSecond);

    /**
     * 找到handler
     * @param ReceiveMessageResponse $res
     * @return mixed
     */
    public function findHandler(ReceiveMessageResponse $res);

    /**
     * 消费者处理消息
     * @param IAsyncHandler $handler
     * @param ReceiveMessageResponse $res
     * @return mixed
     */
    public function processMessage(IAsyncHandler $handler, ReceiveMessageResponse $res);
}