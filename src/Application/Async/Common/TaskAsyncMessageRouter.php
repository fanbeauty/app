<?php

namespace App\Async\Common;

use App\Constants\QueueType;
use App\Service\Queue\Common\AbstractAsyncMessageRouter;
use App\Service\Queue\Common\IAsyncHandler;
use App\Service\Queue\Common\ReceiveMessageResponse;
use App\Service\Queue\Exception\HandlerNotFound;

class TaskAsyncMessageRouter extends AbstractAsyncMessageRouter
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
    }

    public function getConsumer()
    {
        $consumerFactory = ConsumerFactory::getInstance();
        $consumer = $consumerFactory->createConsumer(QueueType::TASK);
        return $consumer;
    }

    public function sendMessage(IAsyncHandler $handler, $message)
    {
        $handlerName = get_class($handler);
        $produceFactory = ProducerFactory::getInstance();
        $produce = $produceFactory->createProducer(QueueType::TASK);
        return $produce->sendMessage(
            serialize([
                'handlerName' => $handlerName,
                'messageBody' => $message,
            ])
        );
    }

    public function sendDelayProcessingMessage(IAsyncHandler $handler, $message, $intervalMillsSecond)
    {
        $handlerName = get_class($handler);
        $produceFactory = ProducerFactory::getInstance();
        $produce = $produceFactory->createProducer(QueueType::TASK);
        return $produce->sendMessage(
            serialize([
                'handlerName' => $handlerName,
                'messageBody' => $message,
            ]),
            $intervalMillsSecond
        );
    }

    public function findHandler(ReceiveMessageResponse $res)
    {
        $message = unserialize($res->getMessageBody());
        $handler = $this->getHandler($message['handlerName']);
        if ($handler && is_a($handler, IAsyncHandler::class)) {
            return $handler;
        } else {
            throw new HandlerNotFound($message['handlerName']);
        }
    }

    public function processMessage(IAsyncHandler $handler, ReceiveMessageResponse $res)
    {
        $message = unserialize($res->getMessageBody());
        $res->setMessageBody($message['messageBody']);
        return $handler->process($res);
    }
}