<?php


namespace Totoro\Mvc\Exception;

class RoutesNotMatched extends RouteException {

    private $request_string;

    public function __construct($request_string) {
        $this->request_string = $request_string;
    }

    public function getRequestString() {
        return $this->request_string;
    }

}

?>
