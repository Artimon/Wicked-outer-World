<?php

interface Controller_Interface {
	/**
	 * @param string $section
	 * @return RendererInterface
	 */
	public function renderer($section);
}
