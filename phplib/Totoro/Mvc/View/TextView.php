<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 17:44
 */

namespace Totoro\Mvc\View;

class TextView extends View
{

    private $str;

    public function __construct($str)
    {
        $this->str = $str;
    }

    public function output()
    {
        $charset = mb_internal_encoding();
        header("Content-Type:text/plain;charset={$charset}");
        echo $this->str;
    }

}