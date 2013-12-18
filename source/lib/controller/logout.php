<?php

class Controller_Logout extends Controller_Abstract {
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
