<?php

abstract class RenderHangarAbstract extends RendererAbstract {
	/**
	 * @return string
	 */
	public function tabsHtml() {
		$router = Router::getInstance();

		$tabs = array(
			$router->fromRequest('garage') => i18n('garage'),
			$router->fromRequest('missions') => i18n('missions')
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
