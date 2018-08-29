<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 12:33
 */

namespace Totoro\Util;

/**
 * 加载类的接口，用于衔接ClassLoader 与 特殊的类加载逻辑的class loader
 * Class IClassLoader
 * @package Totoro\Util
 */
interface IClassLoader
{
    public function load($class_bath_path, $class_name);
}