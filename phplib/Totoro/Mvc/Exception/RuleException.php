<?php

namespace Totoro\Mvc\Exception;

class RuleException extends RouteException {

    private $name;
    private $route;

    public function __construct($name, Route $route, $message) {
        $this->name = $name;
        $this->route = $route;
        parent::__construct($message);
    }

    public function getName() {
        return $this->name;
    }

    public function getRoute() {
        return $this->route;
    }

}

?>
