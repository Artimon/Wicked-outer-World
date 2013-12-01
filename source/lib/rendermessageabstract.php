<?php

abstract class RenderMessageAbstract extends RendererAbstract {
	public function tabsHtml() {
		$controller = $this->controller();

		$tabs = array(
			$controller->section('messages') => "{{'messages'|i18n}}",
			$controller->section('sent') => i18n('sent'),
			$controller->section('write') => "{{'write'|i18n}}"
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