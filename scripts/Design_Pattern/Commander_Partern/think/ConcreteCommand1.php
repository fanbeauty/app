<?php

class ConcreteCommand1 extends Command
{
    //对哪个Receiver类进行处理
    private $receiver;

    public function __construct(Receiver $receiver)
    {
        $this->receiver = $receiver;
    }

    //必须实现一个命令
    public function execute()
    {
        //业务处理
        $this->receiver->doSomething();
    }
}