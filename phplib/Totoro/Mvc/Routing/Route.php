<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 14:26
 */

namespace Totoro\Mvc\Routing;


class Route
{

    private $domain;
    private $pattern;
    private $ori_pattern;
    private $param_key_list = array();
    private $defaults = array();
    private $constraints = array();
    private $namespace;

    //将路由规则转化为对应的正则表达式
    public function initPattern()
    {
        $url_param_pattern = '[^\/]+';
        if (!$this->pattern) {
            // 原始路由规则 /{controller}/{action}/{...} /{controller}/{action}
            // 必须由 / 开始
            if (preg_match('/^\/(.*)/', $this->ori_pattern, $matches)) {
                // 去掉第一个 /
                // {controller}/{action}/{...} {controller}/{action}
                $pattern = $matches[1];
                $pattern_array = explode('/', $pattern);

                $allowAny = true;
                $allowDefault = true;

                // 倒序遍历每一级路由规则
                // {...} -> {action} -> {controller}
                // {action} -> {controller}
                for ($i = count($pattern_array) - 1; $i > -1; $i--) {
                    $pattern_string = $pattern_array[$i];
                    // 如果是一条被定义的路由规则
                    if (preg_match('/{(' . $url_param_pattern . ')}/', $pattern_string, $matches) == 1) {

                        // 被定义的路由规则的变量名
                        // 例：... action controller


                        // 支持 action ... 的写法
                        $param_key_info = (explode(' ', $matches[1]));
                        $param_key = $param_key_info[0];
                        $is_wildcard = isset($param_key_info[1]) ? $param_key_info[1] == '...' : false;
                        array_unshift($this->param_key_list, $param_key);

                        // ... 通配符的逻辑
                        if ($is_wildcard) {
                            if ($allowAny) {
                                // 一个路由规则中只能存在一个通配符
                                $allowAny = false;
                                $this->pattern = '(?:\/(.*?))?' . $this->pattern;
                            } else {
                                throw new \Exception('invailed route rule');
                            }
                        } else {
                            if ($allowDefault && isset($this->defaults[$param_key])) {
                                $this->pattern = '(?:\/(' . $url_param_pattern . '))?' . $this->pattern;
                            } else {
                                $this->pattern = '\/(' . $url_param_pattern . ')' . $this->pattern;
                            }
                        }
                        // 如果是一个固定的值
                    } else {
                        // 下次循环时不允许默认值的存在
                        $allowDefault = false;
                        // 替换固定值中可能会被识别为正则特殊字符的内容
                        $pattern_string = preg_replace('/([\[\]\(\)\+\.])/', '\\\\$1', $pattern_string);

                        $this->pattern = '\/' . $pattern_string . $this->pattern;

                    }
                }
                $this->pattern = '/^' . $this->pattern . '$/';
            } else {
                throw new \Exception('invailed route rule');
            }
        }
    }

    /*
     * /api/wap/home/daydayup
     */
    private function parse($request_string)
    {
        //如果最后一个是/去掉
        if (substr($request_string, -1, 1) == '/' && strlen($request_string) > 1) {
            $request_string = substr($request_string, 0, -1);
        }
        $this->initPattern();
        if (preg_match($this->pattern, $request_string, $matches) == 1) {
            $result = new RouteResult($this);
            $result->setRequestString($request_string);
            $result->setNamespace($this->namespace);

            foreach ($this->param_key_list as $ind => $key) {
                $val = isset($matches[$ind + 1]) ? $matches[$ind + 1] : null;

                if (isset($this->constraints[$key]) && $val !== null) {
                    if (preg_match($this->constraints[$key], $val) == 1) {
                        $result->setParams($key, $val);
                    } else {
                        $result = false;
                        break;
                    }
                } else {
                    $result->setParams($key, isset($matches[$ind + 1]) ? $matches[$ind + 1] : null);
                }
            }
        }
        if ($result) {
            foreach ($this->defaults as $k => $v) {
                if (!$result->getParams($k)) {
                    $result->setParams($k, $v);
                }
            }
        } else {
            $result = false;
        }


        return $result;
    }

    public function __construct($pattern)
    {
        $this->ori_pattern = $pattern;
    }

    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;
    }

    public function setConstraints(array $constraints)
    {
        $this->constraints = $constraints;
    }

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    public function getDefaults()
    {
        return $this->defaults;
    }

    public function getDefault($key)
    {
        return $this->defaults[$key];
    }

    public function getConstraints()
    {
        return $this->constraints;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function execute($request_string)
    {
        return $this->parse($request_string);
    }

}
