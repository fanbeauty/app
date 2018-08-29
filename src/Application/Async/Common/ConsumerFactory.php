<?php

namespace App\Async\Common;

use App\Constants\QueueType;
use App\Service\Queue\MNS\Consumer;

class ConsumerFactory
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function createConsumer($type)
    {
        switch ($type) {
            case QueueType::PUSH:
                return $this->getPushConsumer();
                break;
            case QueueType::TASK:
                return $this->getTaskConsumer();
        }
    }

    private function getPushConsumer()
    {
        return new Consumer('', '', '', '');
    }

    private function getTaskConsumer()
    {
        return new Consumer('', '', '', '');
    }
}