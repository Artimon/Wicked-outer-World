<?php

class ControllerProfile extends ControllerAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererAbstract|RendererInterface
	 */
	public function renderer($section) {
		$account = Game::getInstance()->account();
		$renderer = new RenderProfile($account);

		return $renderer->setController($this);
	}
}
