<?php

class ControllerAccount extends ControllerAbstract {
	/**
	 * @param string $section
	 * @return RendererInterface
	 */
	public function renderer($section) {
		$renderer = new RenderAccount();

		return $renderer->setController($this);
	}
}