<?php

class ControllerLogin extends ControllerAbstract {
	/**
	 * @param string $section
	 * @return RendererInterface|RenderLogin
	 */
	public function renderer($section) {
		return new RenderLogin();
	}
}