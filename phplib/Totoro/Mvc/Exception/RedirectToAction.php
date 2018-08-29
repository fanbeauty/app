<?php

namespace Totoro\Mvc\Exception;

use Totoro\Mvc\Application;
use Totoro\Mvc\Controller;

class RedirectToAction extends RedirectionException {

	private $controller;
	private $action;
	private $params;

	public function __construct(Controller $controller, $action, $params = array()) {
		$this->controller = $controller;
		$this->action = $action;
		$this->params = $params;
	}

	public function getView() {
		return Application::getViewByExecutingAction(
			$this->controller, $this->action, $this->params
		);
	}

}

?>
