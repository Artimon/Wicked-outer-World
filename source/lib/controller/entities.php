<?php

class Controller_Entities extends Controller_Abstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererInterface|RenderTechInfo
	 */
	public function renderer($section) {
		$account = Game::getInstance()->account();

		return new RenderEntities($account);
	}
}