<?php

class RendererQuartersQuarter extends RendererQuartersAbstract {
	public function bodyHtml() {
		$headline = i18n('quarter');
		$description = i18n('grocerDescription');

		return "
			<h2 class='error'>{$headline}</h2>
			<p>{$description}</p>";
	}
}