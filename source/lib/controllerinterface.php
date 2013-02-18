<?php

interface ControllerInterface {
	/**
	 * @param string $section
	 * @return RendererInterface
	 */
	public function renderer($section);
}
