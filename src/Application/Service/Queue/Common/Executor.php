<?php

namespace App\Service\Queue\Common;

class Executor
{
    private $pool = null;

    public function __construct(IAsyncMessageRouter $pool)
    {
        $this->pool = $pool;
    }

    public function run()
    {
        $consumer = $this->pool->getConsumer();
        do {
            try {
                $consumer->receiveMessage($this->pool);
            } catch (\Exception $e) {
                // 任务业务异常都忽略
                echo "AsyncHandler Process Message Failed: " . $e->getMessage();
                echo "ErrorCode: " . $e->getCode() . '\n';
            }
        } while (true);
    }
}
