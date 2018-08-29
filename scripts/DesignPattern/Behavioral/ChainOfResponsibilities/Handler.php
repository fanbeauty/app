<?php

namespace Huany\DesignPattern\Behavioral\ChainOfResponsibilities;

use Psr\Http\Message\RequestInterface;

abstract class Handler
{

    private $successor = null;

    public function __construct(Handler $handler = null)
    {
        $this->successor = $handler;
    }

    public function Handler(RequestInterface $request)
    {
        $processed = $this->processing($request);

        if ($processed === null) {
            if ($this->successor !== null) {
                $processed = $this->successor->Handler($request);
            }
        }

        return $processed;
    }

    abstract function processing(RequestInterface $request);
}