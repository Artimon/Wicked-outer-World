<?php

class Controller_TechInfo extends Controller_Abstract {
	/**
	 * @param string $section
	 * @return RendererInterface|RenderTechInfo
	 */
	public function renderer($section) {
		$techId = $this->request()->get('techId');
		$item = Technology::raw($techId);

		return new RenderTechInfo($item);
	}
}