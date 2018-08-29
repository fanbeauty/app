<?php

namespace App\Service\Queue\Common;

interface IConsumer
{
    public function receiveMessage(IAsyncMessageRouter $messageRouter);
}