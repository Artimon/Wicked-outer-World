<?php

abstract class RenderAcademyAbstract extends RendererAbstract {
	/**
	 * @return string
	 */
	public function tabsHtml() {
		$controller = $this->controller();

		$tabs = array(
			$controller->section('course') => i18n('courses'),
			$controller->section('training') => i18n('training')
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