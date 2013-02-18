<?php

class ControllerFight extends ControllerAbstract {
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
			case 'result':
				$renderer = new RenderFightResult($account);
				break;

			default:
				$renderer = new RenderFightList($account);
				break;
		}

		return $renderer->setController($this);
	}
}
