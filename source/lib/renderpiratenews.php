<?php

class RenderPirateNews extends RendererAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$sql = "
			SELECT
				`name`
			FROM
				`accounts`
			ORDER BY
				`id` DESC
			LIMIT 1;";
		$database = new Lisbeth_Database();
		$playerName = $database->query($sql)->fetchOne();
		$database->freeResult();

		$pirateNews = i18n('pirateNews');
		$latestJoiner = i18n('latestJoiner', $playerName);

		return "
			<h2>{$pirateNews}</h2>
			<p class='highlight'>{$latestJoiner}</p>";
	}

	/**
	 * @return string
	 */
	public function tabsHtml() {
		return '';
	}

	/**
	 * @return bool
	 */
	public function usesBox() {
		return true;
	}
}