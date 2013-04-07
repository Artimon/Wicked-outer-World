<?php

class ControllerBank extends ControllerAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererAbstract|RendererInterface
	 */
	public function renderer($section) {
		$account = Game::getInstance()->account();
		$renderer = new RenderBank($account);

		return $renderer->setController($this);
	}
}