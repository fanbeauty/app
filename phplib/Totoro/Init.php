<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 13:25
 */

namespace Totoro;

use Totoro\Util\ClassLoader;

class Init
{
    public static function bootstrap($totoroBathPath)
    {
        require($totoroBathPath . '/Env.php');
        require($totoroBathPath . '/Util/IClassLoader.php');
        require($totoroBathPath . '/Util/ClassLoader.php');
        $env = Env::getInstance();
        $env->setTotoroBasePath($totoroBathPath);

        $loader = ClassLoader::getInstance();
        $loader->import($totoroBathPath, 'Totoro');
        $loader->register();
    }
}

Init::bootstrap(__DIR__);
