<?php

class ControllerSkirmish extends ControllerAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererAbstract|RendererInterface
	 */
	public function renderer($section) {
		$account = Game::getInstance()->account();

		switch ($section) {
			case 'fight':
				$renderer = new RenderSkirmishFight($account);
				break;

			default:
				$renderer = new RenderSkirmishOpponents($account);
				break;
		}

		return $renderer->setController($this);
	}
}
