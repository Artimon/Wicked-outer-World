<?php

class Controller_UnlockSector extends Controller_Abstract {
	/**
	 * @param string $section
	 * @return RendererInterface|RenderTechInfo
	 */
	public function renderer($section) {
		$renderer = new RenderUnlockSector();

		return $renderer->setController($this);
	}
}