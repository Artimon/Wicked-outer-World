<?php

class ControllerAcademy extends ControllerAbstract {
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
