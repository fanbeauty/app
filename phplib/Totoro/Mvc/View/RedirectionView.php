<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 17:40
 */

namespace Totoro\Mvc\View;

class RedirectionView extends View
{
    private $url;
    private $permanently = false;

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function setPermanently($b = true)
    {
        $this->permanently = $b;
    }

    public function output()
    {
        if ($this->permanently) {
            header('HTTP/1.1 301 Moved Permanently');
        } else {
            header("location:{$this->url}");
        }
    }
}