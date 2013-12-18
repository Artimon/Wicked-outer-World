<?php

class Controller_TravelTo extends Controller_Abstract {
	/**
	 * @param string $section
	 * @return RendererInterface|RenderTechInfo
	 */
	public function renderer($section) {
		$renderer = new RenderTravelTo();

		return $renderer->setController($this);
	}
}