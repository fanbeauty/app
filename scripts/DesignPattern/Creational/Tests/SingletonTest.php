<?php

namespace Huany\DesignPattern\Creational\Singleton\Tests;

use Huany\DesignPattern\Creational\Singleton\Singleton;
use PHPUnit\Framework\TestCase;

class SingletonTest extends TestCase
{
    public function testUniqueness()
    {
        $instance1 = Singleton::getInstance();
        $instance2 = Singleton::getInstance();

        $this->assertInstanceOf(Singleton::class, $instance1);
        $this->assertSame($instance1, $instance2);
    }
}
