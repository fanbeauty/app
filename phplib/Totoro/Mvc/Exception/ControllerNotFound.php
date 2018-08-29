<?php

namespace Totoro\Mvc\Exception;

use Totoro\Mvc\IControllerBuilder;
use Totoro\Mvc\Routing\RouteResult;

class ControllerNotFound extends RouteException {

    private $route_result;
    private $controller_builder_name;

    public function __construct(RouteResult $result, IControllerBuilder $builder) {
        $this->route_result = $result;
        $this->controller_builder_name = get_class($builder);
    }

    public function getRouteResult() {
        return $this->route_result;
    }

    public function getControllerBuilderName() {
        return $this->controller_builder_name;
    }

}
