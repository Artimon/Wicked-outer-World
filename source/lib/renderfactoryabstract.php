<?php

abstract class RenderFactoryAbstract extends RendererAbstract {
	/**
	 * @return bool
	 */
	public function usesBox() {
		return true;
	}

	/**
	 * @return string
	 */
	public function tabsHtml() {
		$controller = $this->controller();

		$tabs = array(
			$controller->section('fiddle') => i18n('fiddle'),
			$controller->section('craft') => i18n('craft'),
			$controller->section('disassemble') => i18n('disassemble')
		);

		return $this->tabsFromArray($tabs);
	}
}