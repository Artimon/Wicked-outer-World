<?php

class RenderTradeDeckEntrance extends RenderTradeDeckAbstract {
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
	 * @return bool
	 */
	public function usesBox() {
		return true;
	}
}