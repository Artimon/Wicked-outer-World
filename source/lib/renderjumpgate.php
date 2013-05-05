<?php

class RenderJumpGate extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$jumpGate = i18n('jumpGate');
		$inPreparation = i18n('inPreparation');

		return "
			<h2>{$jumpGate}</h2>
			<p>{$inPreparation}</p>";
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