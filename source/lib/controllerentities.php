<?php

class ControllerEntities extends ControllerAbstract {
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