<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 17:10
 */

namespace Totoro\Mvc\View;

class HtmlView extends View
{
    private $templateFile;
    private $templateData = array();

    public function __construct($tmpl)
    {
        $this->templateFile = $tmpl;
    }

    public function assign($key, $val)
    {
        $this->templateData[$key] = $val;
        return true;
    }

    public function getDataSet()
    {
        return $this->templateData;
    }

    public function setData($arr)
    {
        foreach ($arr as $k => $v) {
            $this->assign($k, $v);
        }
    }

    public function output()
    {
        extract($this->templateData);
        include_once($this->templateFile);
    }
}