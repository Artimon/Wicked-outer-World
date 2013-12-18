<?php

class Controller_Hangar extends Controller_ModuleAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererAbstract|RendererInterface
	 */
	public function renderer($section) {
		$this->assertModule(new Starbase_Module_Hangar());

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
