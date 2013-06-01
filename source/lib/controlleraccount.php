<?php

class ControllerAccount extends ControllerAbstract {
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