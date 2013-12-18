<?php

class Controller_Account extends Controller_Abstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererInterface
	 */
	public function renderer($section) {
		$renderer = new RenderAccount();

		return $renderer->setController($this);
	}
}