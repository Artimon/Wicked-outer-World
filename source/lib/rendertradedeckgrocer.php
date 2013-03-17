<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Pascal
 * Date: 17.03.13
 * Time: 09:30
 * To change this template use File | Settings | File Templates.
 */

class RenderTradeDeckGrocer extends RenderTradeDeckAbstract {
	public function bodyHtml() {
		$headline = i18n('grocer');
		$description = i18n('grocerDescription');

		return "
			<h2 class='error'>{$headline}</h2>
			<p>{$description}</p>";
	}
}