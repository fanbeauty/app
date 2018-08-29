<?php
/**
 * User: Major
 * Date: 2018/4/17
 * Time: 0:12
 */

namespace App;

class Env
{
    private $basePath;

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new self();
        return self::$instance;
    }

    public function setBasePath($param)
    {
        $this->basePath = $param;
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function getConfPath()
    {
        return $this->basePath . '/conf';
    }
}
