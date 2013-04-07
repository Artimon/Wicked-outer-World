<?php

interface RendererInterface {
	/**
	 * @return string
	 */
	public function bodyHtml();

	/**
	 * @return string
	 */
	public function tabsHtml();

	/**
	 * Return true if a content-box shall be created.
	 *
	 * @return bool
	 */
	public function usesBox();
}
