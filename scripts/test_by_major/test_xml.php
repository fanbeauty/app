<?php
/**
 * User: Major
 * Date: 2018/4/28
 * Time: 17:14
 */

$dir = dirname(dirname(__DIR__));
require "{$dir}/init.php";

$env = \App\Env::getInstance();
$db_path = $env->getConfPath() . DIRECTORY_SEPARATOR . 'db.xml';
$xml = new \Totoro\Config\Xml($db_path);
$ret = $xml->get("/mysql");
var_dump($ret);