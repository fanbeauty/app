<?php

namespace Totoro\Mvc\Exception;

class ViewTypeException extends RouteException {

    private $invalid_type;

    public function __construct($invalid_type) {
        $this->invalid_type = $invalid_type;
    }

    public function getInvalidType() {
        return $this->invalid_type;
    }

}

?>
