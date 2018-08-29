<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 17:24
 */

namespace Totoro\Mvc\View;

class JsonView extends View
{
    private $data;
    private $callback;

    //将输出的json数据转化为text
    private $output_in_string = false;

    private static function deepFormat(&$result)
    {
        if (is_array($result)) {
            foreach ($result as $k => $v) {
                self::deepFormat($result[$k]);
            }
        } else {
            if (is_bool($result))
                $result = $result ? '1' : '0';
            else
                $result = strval($result);
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setJavaScriptCallback($callback)
    {
        $this->callback = $callback;
    }

    public function setOutputInScript($b = true)
    {
        $this->output_in_string = $b ? true : false;
    }

    public function output()
    {
        $arr = $this->data;
        if ($this->output_in_string) {
            self::deepFormat($arr);
        }
        $json = json_encode($arr);
        if ($this->callback && self::isValidJsonp($this->callback)) {
            header("Content-Type:application/javascript;charset=UTF-8");
            echo "{$this->callback}({$json})";
        } else {
            header("Content-Type:application/json;charset=UTF-8");
            echo $json;
        }
    }

    protected static function isValidJsonp($jsonp)
    {
        $pattern = '#^[A-Za-z0-9_]*$#';
        $ret = preg_match($pattern, $jsonp) ? true : false;
        return $ret;
    }

}