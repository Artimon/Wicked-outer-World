<?php

class RenderTradeDeckStarships extends RenderTradeDeckAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$headline = i18n('starships');
		$description = i18n('grocerDescription');

		return "
			<h2 class='error'>{$headline}</h2>
			<p>{$description}</p>";
	}
}