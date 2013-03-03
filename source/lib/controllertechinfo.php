<?php

class ControllerTechInfo extends ControllerAbstract {
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