<?php

abstract class RenderHangarAbstract extends RendererAbstract {
	/**
	 * @return string
	 */
	public function tabsHtml() {
		$controller = $this->controller();

		$tabs = array(
			$controller->section('garage') => i18n('garage'),
			$controller->section('missions') => i18n('missions')
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
