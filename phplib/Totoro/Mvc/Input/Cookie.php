<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 19:21
 */

namespace Totoro\Mvc\Input;

class Cookie extends AbstractInput
{
    private static $instance = null;

    protected function __construct()
    {
        parent::__construct($_COOKIE);
    }

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;
        return self::$instance;
    }
}