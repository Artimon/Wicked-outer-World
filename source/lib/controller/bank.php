<?php

class Controller_Bank extends Controller_ModuleAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererAbstract|RendererInterface
	 */
	public function renderer($section) {
		$this->assertModule(new Starbase_Module_Bank());

		$account = Game::getInstance()->account();
		$renderer = new RenderBank($account);

		return $renderer->setController($this);
	}
}