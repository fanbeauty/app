<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 13:28
 */

namespace Totoro;

/**
 * 全局配置类
 * Class Env
 * @package Totoro
 */
class Env
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private $totoroBasePath;
    private $unsetRequestGlobals = false;

    private function __construct()
    {
    }

    public function setTotoroBasePath($totoroBathPath)
    {
        $this->totoroBasePath = $totoroBathPath;
    }

    public function getTotoroBathPath()
    {
        return $this->totoroBasePath;
    }

    public function unsetRequestGlobals()
    {
        $this->unsetRequestGlobals = true;
    }

    public function isUnsetRequestGlobals()
    {
        return $this->unsetRequestGlobals;
    }
}