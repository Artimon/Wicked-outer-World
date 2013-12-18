<?php

class Controller_VersionLog extends Controller_Abstract {
	/**
	 * @param string $section
	 * @return RenderImprint
	 */
	public function renderer($section) {
		$renderer = new RenderVersionLog();

		return $renderer->setController($this);
	}
}