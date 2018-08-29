<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 14:21
 */

namespace Totoro\Mvc\Routing;

class RouteResult
{
    private $route;
    private $name;
    private $params = array();
    private $request_string;
    private $namespace = null;

    public function __construct(Route $r)
    {
        $this->route = $r;
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getParamArray()
    {
        return $this->params;
    }

    /**
     * @return array
     */
    public function getParams($key)
    {
        return isset($this->params[$key]) ? $this->params[$key] : null;
    }

    /**
     * @param array $params
     */
    public function setParams($key, $value)
    {
        $this->params[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getRequestString()
    {
        return $this->request_string;
    }

    /**
     * @param mixed $request_string
     */
    public function setRequestString($request_string)
    {
        $this->request_string = $request_string;
    }

    /**
     * @return null
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param null $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    public function hasNamespace()
    {
        return $this->namespace !== null;
    }

}