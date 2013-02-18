<?php

class ControllerHangar extends ControllerAbstract {
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
			case 'missions':
				$renderer = new RenderHangarMissions($account);
				break;

			case 'garage':
				$renderer = new RenderHangarDesigner($account);
				break;

			case 'starTrip':
				$renderer = new RenderHangarStarTrip($account);
				break;

			default:
				$renderer = new RenderHangarEntrance($account);
				break;
		}

		return $renderer->setController($this);
	}
}
