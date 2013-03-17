<?php

class RendererQuartersEntrance extends RendererQuartersAbstract {
	public function bodyHtml() {
		$headline = i18n('quarters');
		$description = i18n('quartersDescription');

		return "
			<h2>{$headline}</h2>
			<p>{$description}</p>";
	}
}