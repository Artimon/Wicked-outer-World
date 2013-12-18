<?php

class Controller_Ranking extends Controller_Abstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererAbstract|RendererInterface
	 */
	public function renderer($section) {
		$renderer = new RenderRanking();

		return $renderer->setController($this);
	}
}