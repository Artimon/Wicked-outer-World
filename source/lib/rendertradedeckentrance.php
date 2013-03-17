<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pascal
 * Date: 17.03.13
 * Time: 09:20
 * To change this template use File | Settings | File Templates.
 */

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