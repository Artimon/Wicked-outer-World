<?php

abstract class RenderMessageAbstract extends RendererAbstract {
	public function tabsHtml() {
		$controller = $this->controller();

		$tabs = array(
			$controller->section('messages') => i18n('messages'),
			$controller->section('sent') => i18n('sent'),
			$controller->section('write') => i18n('write')
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