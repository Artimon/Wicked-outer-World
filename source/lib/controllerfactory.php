<?php

class ControllerFactory extends ControllerAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RenderCrafter|RendererInterface
	 */
	public function renderer($section) {
		$account = $this->game()->account();

		$renderer = new RenderCrafter($account);

		return $renderer->setController($this);
	}
}