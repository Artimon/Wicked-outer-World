<?php

class Controller_Academy extends Controller_ModuleAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererAbstract|RendererInterface
	 */
	public function renderer($section) {
		$this->assertModule(new Starbase_Module_Academy());

		$account = Game::getInstance()->account();

		switch ($section) {
			case 'course':
				$renderer = new RenderAcademyCourse($account);
				break;

			case 'training':
				$renderer = new RenderAcademyTraining($account);
				break;

			default:
				$renderer = new RenderAcademyEntrance($account);
				break;
		}

		return $renderer->setController($this);
	}
}
