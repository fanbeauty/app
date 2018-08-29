<?php

class Cook extends AbstractReceiver
{
    public function whoAmI()
    {
        return 'I\'m a cooker';
    }

    public function meal()
    {
        echo '番茄炒鸡蛋' . PHP_EOL;
    }

    public function drink()
    {
        echo '紫菜葱花汤' . PHP_EOL;
    }

    public function ok()
    {
        echo '做好了' . PHP_EOL;
    }
}