<?php

class ControllerPirateNews extends ControllerAbstract {
	public function renderer($section) {
		$renderer = new RenderPirateNews();
		return $renderer->setController($this);
	}
}