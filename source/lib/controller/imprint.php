<?php

class Controller_Imprint extends Controller_Abstract {
	/**
	 * @param string $section
	 * @return RenderImprint
	 */
	public function renderer($section) {
		$renderer = new RenderImprint();

		return $renderer->setController($this);
	}
}