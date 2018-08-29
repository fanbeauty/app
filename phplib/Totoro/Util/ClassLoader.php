<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 12:36
 */

namespace Totoro\Util;

/**
 * 加载类实现的工具
 * @package Totoro\Util
 */
class ClassLoader implements IClassLoader
{

    private static $instance = null;

    //注册树模式，保存import方法导入的namespace信息
    private $library_list = array();


    /**
     *
     * $loader->import($basePath.'/src/TengYue','TengYue');
     *
     * $library_list
     * ['TengYue':['reg_ns':'TengYue','class_bath_path':$basePath.'/src/TengYue','loader':$loader]]
     *
     */
    //use TengYue\Models\Daos\Open\OpenAccountBindBO
    // --> $basePath.'/src/TengYue/Models/Daos/Open/OpenAccountBindBO.php'

    public static function loadCallback($className)
    {
        $loader = self::getInstance();
        $namespaces = explode('\\', $className);
        if (count($namespaces) > 1) {
            $library_info = $loader->getLibraryInfo($className);

            if (substr($library_info['reg_ns'], -1, 1) != '\\')
                $library_info['reg_ns'] .= '\\';

            $className = str_replace($library_info['reg_ns'], '', $className);

            if ($library_info['loader']) {
                return $library_info['loader']->load($library_info['class_bath_path']);
            } else {
                return $loader->load($library_info['class_bath_path'], $className);
            }
        } else {
            return false;
        }
    }


    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new ClassLoader();
        }
        return self::$instance;
    }

    //单例模式
    private function __construct()
    {
    }

    /*
     * import
     * 针对特定class自定义class loader类，实现自定义逻辑的类的加载
     */
    public function import($class_base_path, $root_namespace, IClassLoader $Loader = null, $ext_config = array())
    {
        if (is_dir($class_base_path)) {
            if (substr($class_base_path, -1, 1) != DIRECTORY_SEPARATOR) {
                $class_base_path .= DIRECTORY_SEPARATOR;
            }
            $ext_config['class_bath_path'] = $class_base_path;
            $this->setLibraryInfo($root_namespace, $ext_config, $Loader);
            return true;
        } else {
            return false;
        }
    }

    /*
     * register
     * 将ClassLoader加载类的回调函数注册到php中
     */
    public function register()
    {
        spl_autoload_register('Totoro\Util\ClassLoader::loadCallback');
    }

    /*
     * unregister
     */
    public function unregister()
    {
        spl_autoload_unregister('Totoro\Util\ClassLoader::loadCallback');
    }


    protected function setLibraryInfo($root_namespace, array $ext_config, IClassLoader $loader = null)
    {
        if (empty($this->library_list[$root_namespace])) {
            $this->library_list[$root_namespace] =
                array(
                    'reg_ns' => $root_namespace,
                    'class_bath_path' => $ext_config['class_bath_path'],
                    'loader' => $loader
                );
            //每次加载后排序，防止注册一个短ns导致加载异常
            krsort($this->library_list);
        } else {
            //todo 想一下如何处理这个异常
        }
    }

    protected function getLibraryInfo($class_name)
    {
        foreach ($this->library_list as $reg_ns => $info) {
            if (strpos($class_name, $reg_ns) === 0) {
                return $info;
            }
        }
        return false;
    }

    public function load($class_bath_path, $class_name)
    {
        $relt_filename = str_replace('\\', DIRECTORY_SEPARATOR, $class_name);
        $load = "{$class_bath_path}{$relt_filename}.php";
        !file_exists($load) ?: require_once($load);
        return class_exists($class_name, false);
    }

}