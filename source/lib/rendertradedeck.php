<?php

class RenderTradeDeck extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$headline = i18n('tradeDeck');
		$description = i18n('tradeDeckDescription');

		return "
			<h2>{$headline}</h2>
			<p>{$description}</p>";
	}

	/**
	 * @return string
	 */
	public function tabsHtml() {
		$controller = $this->controller();

		$tabs = array(
			$controller->section('starships') => i18n('starships'),
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