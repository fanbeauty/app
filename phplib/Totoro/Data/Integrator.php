<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 23:26
 */

namespace Totoro\Data;

abstract class Integrator
{
    private $loader;

    public function __construct(AbstractLoader $loader)
    {
        $this->loader = $loader;
    }

    final public function getLoader()
    {
        return $this->loader;
    }

    final public function getDetail($primary_key)
    {
        return $this->loader->getDetail($primary_key);
    }
}