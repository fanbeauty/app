<?php

$basePath = $_SERVER['APP_BASE_PATH'];

require($basePath . '/init.php');

use Totoro\Env;
use Totoro\Mvc\Application;

//删除全局变量
$env = Env::getInstance();
$env->unsetRequestGlobals();

//初始化app
$app = Application::getInstance();

$app->mapRoute(
    'api',
    '/api/{sub-namespace ...}/{controller}/{action}',
    array('controller' => 'default', 'action' => 'v1'),
    array(),
    'App\Controllers\api'
);
//执行
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$app->start($path);
