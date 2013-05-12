<?php

class ControllerImprint extends ControllerAbstract {
	/**
	 * @param string $section
	 * @return RenderImprint
	 */
	public function renderer($section) {
		$renderer = new RenderImprint();

		return $renderer->setController($this);
	}
}