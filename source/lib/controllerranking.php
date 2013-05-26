<?php

class ControllerRanking extends ControllerAbstract {
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