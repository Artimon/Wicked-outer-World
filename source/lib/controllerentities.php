<?php

class ControllerEntities extends ControllerAbstract {
	/**
	 * @param string $section
	 * @return RendererInterface|RenderTechInfo
	 */
	public function renderer($section) {
		$account = Game::getInstance()->account();

		return new RenderEntities($account);
	}
}