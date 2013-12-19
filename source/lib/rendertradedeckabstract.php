<?php

abstract class RenderTradeDeckAbstract extends RendererAbstract {
	/**
	 * @return string
	 */
	public function tabsHtml() {
		$controller = $this->controller();

		$tabs = array(
			$controller->section('shop') => "{{'shop'|i18n}}",
			$controller->section('grocer') => i18n('grocer'),
			$controller->section('starships') => "{{'starships'|i18n}}",
			$controller->section('airlock') => i18n('airlock')
		);

		return $this->tabsFromArray($tabs);
	}

	/**
	 * @return bool
	 */
	public function usesBox() {
		return true;
	}
}