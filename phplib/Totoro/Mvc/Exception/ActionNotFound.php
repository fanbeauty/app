<?php

namespace Totoro\Mvc\Exception;

class ActionNotFound extends RouteException {

    private $controller_name;
    private $action_name;

    public function __construct($controller_name, $action_name) {
        $this->controller_name = $controller_name;
        $this->action_name = $action_name;
    }

    public function getControllerName() {
        return $this->controller_name;
    }

    public function getRequestActionName() {
        return $this->action_name;
    }

}
