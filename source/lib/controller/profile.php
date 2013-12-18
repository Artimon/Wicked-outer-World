<?php

class Controller_Profile extends Controller_Abstract {
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
