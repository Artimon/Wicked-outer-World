<?php

class RendererQuartersQuarter extends RendererQuartersAbstract {
	public function bodyHtml() {
		$headline = i18n('quarter');
		$description = i18n('inPreparation');

		return "
			<h2 class='error'>{$headline}</h2>
			<p>{$description}</p>";
	}
}