<?php

class ControllerLogout extends ControllerAbstract {
	/**
	 * @param string $section
	 * @return RendererInterface|RenderLogout
	 */
	public function renderer($section) {
		return new RenderLogout();
	}
}
