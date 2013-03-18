<?php

class RenderFactoryDisassemble extends RenderFactoryAbstract {
	/**
	 * @return string
	 */
	public function bodyHtml() {
		$headline = i18n('disassemble');
		$description = i18n('grocerDescription');

		return "
			<h2 class='error'>{$headline}</h2>
			<p>{$description}</p>";
	}
}