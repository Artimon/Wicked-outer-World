<?php

class ControllerLogout extends ControllerAbstract {
	public function __construct() {
		$this->assertOnline();
	}

	/**
	 * @param string $section
	 * @return RendererInterface|RenderLogout
	 */
	public function renderer($section) {
		return new RenderLogout();
	}
}
