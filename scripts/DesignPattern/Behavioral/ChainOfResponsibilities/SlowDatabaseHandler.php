<?php
/**
 * Created by PhpStorm.
 * User: m1783
 * Date: 2018/6/3
 * Time: 23:53
 */

namespace Huany\DesignPattern\Behavioral\ChainOfResponsibilities;

use Psr\Http\Message\RequestInterface;

class SlowDatabaseHandler extends Handler
{
    function processing(RequestInterface $request)
    {
        return 'Hello World';
    }
}