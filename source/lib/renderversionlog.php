<?php

class RenderVersionLog extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$template = new Leviathan_Template();

		return $template->render('source/view/versionLog.php');
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