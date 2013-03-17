<?php

class RenderHangarEntrance extends RenderHangarAbstract {
	public function bodyHtml() {
		$headline = i18n('hangar');
		$description = i18n('hangarDescription');

		return "
			<h2>{$headline}</h2>
			<p>{$description}</p>";
	}
}
