<?php

namespace App\Service\Queue\Common;

abstract class  AbstractAsyncMessageRouter implements IAsyncMessageRouter
{
    private $_pool = [];

    /**
     * @param IAsyncHandler $handler
     * @return void
     */
    public function registerHandler(IAsyncHandler $handler)
    {
        $className = get_class($handler);
        $this->_pool[$className] = $handler;
    }

    /**
     * @param $className
     * @return IAsyncHandler $handler
     */
    public function getHandler($className)
    {
        return $this->_pool[$className];
    }
}