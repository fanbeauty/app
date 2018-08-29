<?php

namespace Totoro\Mvc\Exception;

abstract class RedirectionException extends \Exception
{

    abstract public function getView();

}
