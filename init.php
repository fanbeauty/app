<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 14:01
 */

if (PHP_OS !== 'Linux') {
    $_SERVER['APP_BASE_PATH'] = __DIR__;
}

//定义根目录
$basePath = $_SERVER['APP_BASE_PATH'];
//框架初始化
require($basePath . '/phplib/Totoro/Init.php');

//注册项目命名空间
$loader = Totoro\Util\ClassLoader::getInstance();
$loader->import($basePath . '/src/Application', 'App');

//App 初始化
$appEnv = \App\Env::getInstance();
$appEnv->setBasePath($basePath);
