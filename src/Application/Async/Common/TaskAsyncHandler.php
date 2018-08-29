<?php

namespace App\Async\Common;

use App\Service\Queue\Common\IAsyncHandler;
use App\Service\Queue\Common\ReceiveMessageResponse;
use App\Service\Queue\Common\SendMessageResponse;

abstract class TaskAsyncHandler implements IAsyncHandler
{
    public function call($message)
    {
        $router = TaskAsyncMessageRouter::getInstance();
        return $router->sendMessage($this, $message);
    }

    public function callInterval($message, $intervalMilliSecond)
    {
        $router = TaskAsyncMessageRouter::getInstance();
        return $router->sendDelayProcessingMessage(
            $this, $message, $intervalMilliSecond
        );
    }

    abstract public function process(ReceiveMessageResponse $res);
}