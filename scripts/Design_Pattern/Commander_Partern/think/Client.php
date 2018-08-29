<?php

class Client
{
    public static function run()
    {
        //首先声明调用者Invoker
        $invoker = new Invoker();
        //定义接受者
        $receiver = new ConcreteReceiver1();
        //定义一个发送给接受者的命令
        $command = new ConcreteCommand1($receiver);
        //把命令交给调用者去执行
        $invoker->setCommand($command);
        $invoker->action();
    }
}

Client::run();