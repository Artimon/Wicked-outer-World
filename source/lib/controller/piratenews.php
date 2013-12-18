<?php

class Controller_PirateNews extends Controller_Abstract {
	public function renderer($section) {
		$renderer = new RenderPirateNews();
		return $renderer->setController($this);
	}
}