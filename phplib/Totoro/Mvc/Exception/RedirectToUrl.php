<?php

namespace Totoro\Mvc\Exception;

use Totoro\Mvc\View\RedirectionView;

class RedirectToUrl extends RedirectionException
{

    private $url;
    private $permanently;

    public function __construct($url, $permanently = false)
    {
        $this->url = $url;
        $this->permanently = $permanently;
    }

    public function getView()
    {
        $view = new RedirectionView();
        $view->setUrl($this->url);
        $view->setPermanently($this->permanently);
        return $view;
    }
}

