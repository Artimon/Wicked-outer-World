<?php

class RenderLogout extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$session = new Leviathan_Session();
		$session->reset();

		return 'Thanks for loggin out ya twat!';
	}

	/**
	 * @return string
	 */
	public function tabsHtml() {
		return '';
	}

	/**
	 * @return bool
	 */
	public function usesBox() {
		return true;
	}
}
