<?php

namespace App\Async\Common;

use App\Constants\QueueType;
use App\Service\Queue\MNS\Producer;

class ProducerFactory
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function createProducer($type)
    {
        switch ($type) {
            case QueueType::PUSH:
                return $this->getPushProducer();
                break;
            case QueueType::TASK:
                return $this->getTaskProducer();
                break;
        }
    }

    private function getPushProducer()
    {
        return new Producer('', '', '', '');
    }

    private function getTaskProducer()
    {
        return new Producer('', '', '', '');
    }
}