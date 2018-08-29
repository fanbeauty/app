<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 14:08
 */

namespace Totoro\Mvc;

use Totoro\Mvc\Exception\ApplicationException;
use Totoro\Mvc\Exception\RouteException;

interface IExceptionCallback
{
    public function onRouteException(RouteException $e);

    public function onApplicationException(ApplicationException $e);

//    public function onDatabaseException(DatabaseException $e);

    public function onException(\Exception $e);
}