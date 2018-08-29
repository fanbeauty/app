<?php

namespace App\Service\Queue\Common;

interface IAsyncHandler
{
    /**
     * @param $message
     * @return SendMessageResponse
     */
    public function call($message);

    /**
     * @param $message
     * @param $intervalMilliSecond
     * @return SendMessageResponse
     */
    public function callInterval($message, $intervalMilliSecond);

    /**
     * @param ReceiveMessageResponse $res
     * @return boolean
     */
    public function process(ReceiveMessageResponse $res);
}