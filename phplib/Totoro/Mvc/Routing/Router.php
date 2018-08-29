<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 14:26
 */

namespace Totoro\Mvc\Routing;

class Router
{
    private static $instance = null;
    private $route_list = array();

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function route($request_string)
    {
        foreach ($this->route_list as $info) {
            $name = $info['name'];
            $route = $info['route'];
            try {
                $result = $route->execute($request_string);
                if ($result) {
                    $result->setName($name);
                    return $result;
                }
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage(), $e->getCode());
            }
        }
        return false;
    }

    /*
     * add
     */
    public function add($name, $patten, $defaults = array(), $constrains = array(), $namespace = null)
    {
        $route = new Route($patten);
        $route->setDefaults($defaults);
        $route->setConstraints($constrains);
        $route->setNamespace($namespace);
        $this->route_list[] = array(
            'name' => $name,
            'route' => $route
        );
    }

    /**
     * prepend
     */
    public function prepend($name, $patten, $defaults = array(), $constraints = array(), $namespace = null)
    {
        $route = new Route($patten);
        $route->setDefaults($defaults);
        $route->setConstraints($constraints);
        $route->setNamespace($namespace);
        array_unshift($this->route_list, array(
            'name' => $name,
            'route' => $route,
        ));
    }

    /*
     * getRoute
     */
    public function getRoute($name)
    {
        foreach ($this->route_list as $info) {
            $_name = $info['name'];
            if ($_name == $name) {
                return $info['route'];
            }
        }
        return null;
    }


}