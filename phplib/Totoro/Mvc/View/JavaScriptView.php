<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 17:18
 */

namespace Totoro\Mvc\View;

class JavaScriptView extends View
{
    private $script;
    private $domain;

    public function __construct()
    {
    }

    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    public function append($str)
    {
        $this->script .= $str;
    }

    public function output()
    {
        if ($this->domain) {
            $this->script = 'document.domain="' . $this->domain . '";' . $this->script;
        }
        $charset = mb_internal_encoding();
        header("Content-Type:application/javascript;charset={$charset}");
        echo "<script type=\"text/javascript\">{$this->script}</script>";
    }
}