<?php

class Controller_Register extends Controller_Abstract {
	/**
	 * @param string $section
	 * @return RendererInterface|RenderRegister
	 */
	public function renderer($section) {
		$renderer = new RenderRegister();

		return $renderer->setController($this);
	}
}