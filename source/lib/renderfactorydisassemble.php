<?php

class RenderFactoryDisassemble extends RenderFactoryAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$headline = i18n('disassemble');
		$description = i18n('inPreparation');

		return "
			<h2 class='error'>{$headline}</h2>
			<p>{$description}</p>";
	}
}