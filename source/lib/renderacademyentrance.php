<?php

class RenderAcademyEntrance extends RenderAcademyAbstract {
	public function bodyHtml() {
		$welcome = i18n('academyWelcome');
		$description = i18n('academyDescription');

		return "
			<h2>{$welcome}</h2>
			<p>{$description}</p>";
	}
}
