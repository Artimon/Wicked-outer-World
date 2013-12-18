<?php

class Controller_Skirmish extends Controller_ModuleAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererAbstract|RendererInterface
	 */
	public function renderer($section) {
		$this->assertModule(new Starbase_Module_Skirmish());

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
