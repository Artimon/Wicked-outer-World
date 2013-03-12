<?php

class ControllerRegister extends ControllerAbstract {
	/**
	 * @param string $section
	 * @return RendererInterface|RenderRegister
	 */
	public function renderer($section) {
		$renderer = new RenderRegister();

		return $renderer->setController($this);
	}
}