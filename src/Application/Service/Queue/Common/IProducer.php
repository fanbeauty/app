<?php

namespace App\Service\Queue\Common;

interface IProducer
{
    /**
     * @param $message
     * @return SendMessageResponse
     */
    public function sendMessage($message);

    /**
     * @param $message
     * @param $intervalMillSecond
     * @return SendMessageResponse
     */
    public function sendDelayProcessingMessage($message, $intervalMillSecond);
}