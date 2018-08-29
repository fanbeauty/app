<?php

//调用者 类比 服务员->厨师  项目leader->工程部

class Invoker
{
    private $command;

    //受包气，接受命令
    public function setCommand(Command $command)
    {
        $this->command = $command;
    }

    public function action()
    {
        $this->command->execute();
    }
}