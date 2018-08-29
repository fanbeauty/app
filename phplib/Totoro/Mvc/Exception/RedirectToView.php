<?php

namespace Totoro\Mvc\Exception;

use Totoro\Mvc\View\View;

class RedirectToView extends RedirectionException {

	private $view;

	public function __construct(View $view) {
		$this->view = $view;
	}

	public function getView() {
		return $this->view;
	}

}
