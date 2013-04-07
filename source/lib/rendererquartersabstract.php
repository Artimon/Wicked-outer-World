<?php

abstract class RendererQuartersAbstract extends RenderTradeDeckAbstract {
	/**
	 * @return string
	 */
	public function tabsHtml() {
		$controller = $this->controller();

		$tabs = array(
			$controller->section('quarter') => i18n('quarter'),
			$controller->section('lounge') => i18n('lounge')
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