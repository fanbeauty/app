<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 14:07
 */

namespace Totoro\Mvc;

use Totoro\Mvc\Routing\RouteResult;

interface IControllerBuilder
{
    public function build(RouteResult $route_result);
}